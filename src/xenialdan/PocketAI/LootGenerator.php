<?php

namespace xenialdan\PocketAI;

use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\plugin\PluginException;
use pocketmine\Server;
use xenialdan\PocketAI\entitytype\AIEntity;

class LootGenerator{
	private $lootname = "empty";
	private $entity;
	private $lootFile = [];

	/**
	 * LootGenerator constructor.
	 * @param $lootname
	 * @param AIEntity|null $entity
	 */
	public function __construct($lootname = "loot_tables/empty.json", AIEntity $entity = null){
		$lootname = str_replace(".json", "", $lootname);
		if (!array_key_exists($lootname, Loader::$loottables)) throw new \InvalidArgumentException("LootTable " . $lootname . " not found" . (is_null($entity) ? "" : " for entity of type " . $entity->getName()));
		$this->lootname = $lootname;
		$this->lootFile = Loader::$loottables[$this->lootname];
		$this->entity = $entity;
	}

	public function getRandomLoot(){
		$items = [];
		if (!isset($this->lootFile["pools"])){
			return $items;
		}
		foreach ($this->lootFile["pools"] as $rolls){//TODO sub-pools, see armor chain etc
			//TODO roll conditions.. :(
			//TODO i saw "tiers" and have no idea what these do
			$array = [];
			$maxrolls = $rolls["rolls"];//TODO: $rolls["conditions"]
			while ($maxrolls > 0){
				$maxrolls--;
				//TODO debug this roll condition check
				if (isset($rolls["conditions"])){
					if (!API::checkConditions($this->entity, $rolls["conditions"])) continue;
				}
				//
				foreach ($rolls["entries"] as $index => $entries){
					$array[] = $entries["weight"] ?? 1;
				}
			}
			$val = $rolls["entries"][$this->getRandomWeightedElement($array)];
			//typecheck
			if ($val["type"] == "loot_table"){
				$loottable = new LootGenerator($val["name"], $this->entity);
				$items = array_merge($items, $loottable->getRandomLoot());
				unset($loottable);
			} elseif ($val["type"] == "item"){
				print $val["name"] . PHP_EOL;
				//name fix
				if ($val["name"] == "minecraft:fish" || $val["name"] == "fish") $val["name"] = "raw_fish";//TODO proper name fixes via API
				$item = Item::fromString($val["name"]);
				if (isset($val["functions"])){
					foreach ($val["functions"] as $function){
						switch ($functionname = str_replace("minecraft:", "", $function["function"])){
							case "set_damage": {
								if ($item instanceof Tool) $item->setDamage(mt_rand($function["damage"]["min"] * $item->getMaxDurability(), $function["damage"]["max"] * $item->getMaxDurability()));
								else $item->setDamage(mt_rand($function["damage"]["min"], $function["damage"]["max"]));
								break;
							}
							case "set_data": {
								//fish fix, blame mojang
								switch ($item->getId()){
									case Item::RAW_FISH: {
										switch ($function["data"]){
											case 1:
												$item = Item::get(Item::RAW_SALMON, $item->getDamage(), $item->getCount(), $item->getCompoundTag());
												break;
											case 2:
												$item = Item::get(Item::CLOWNFISH, $item->getDamage(), $item->getCount(), $item->getCompoundTag());
												break;
											case 3:
												$item = Item::get(Item::PUFFERFISH, $item->getDamage(), $item->getCount(), $item->getCompoundTag());
												break;
											default:
												break;
										}
										break;
									}
									default: {
										$item->setDamage($function["data"]);
									}
								}
								break;
							}
							case "set_count": {
								$item->setCount(mt_rand($function["count"]["min"], $function["count"]["max"]));
								break;
							}
							case "furnace_smelt": {
								if (isset($function["conditions"])){
									if (!API::checkConditions($this->entity, $function["conditions"])) break;
								}
								// todo foreach condition API::checkConditions
								if ((!is_null($this->entity) && $this->entity->isOnFire()) || is_null($this->entity))
									$item = Server::getInstance()->getCraftingManager()->matchFurnaceRecipe($item)->getResult();
								break;
							}
							case "enchant_randomly": {
								//TODO
								break;
							}
							case "enchant_with_levels": {
								/*
                            "function": "enchant_with_levels",
                            "levels": 30,
                            "treasure": true
								 */
								//TODO
								break;
							}
							case "looting_enchant": {
								$item->setCount($item->getCount() + mt_rand($function["count"]["min"], $function["count"]["max"]));
								break;
							}
							case "enchant_random_gear": {
								break;
							}
							case "set_data_from_color_index": {
								//TODO maybe use ColorBlockMetaHelper::getColorFromMeta();
								break;
							}
							default:
								assert("Unknown looting table function $functionname, skipping");
						}
					}
				}
				$items[] = $item;
			} elseif ($val['type'] === "empty"){

			}
		}
		return $items;
	}

	/**
	 * https://stackoverflow.com/a/11872928/4532380
	 * getRandomWeightedElement()
	 * Utility function for getting random values with weighting.
	 * Pass in an associative array, such as array('A'=>5, 'B'=>45, 'C'=>50)
	 * An array like this means that "A" has a 5% chance of being selected, "B" 45%, and "C" 50%.
	 * The return value is the array key, A, B, or C in this case.  Note that the values assigned
	 * do not have to be percentages.  The values are simply relative to each other.  If one value
	 * weight was 2, and the other weight of 1, the value with the weight of 2 has about a 66%
	 * chance of being selected.  Also note that weights should be integers.
	 *
	 * @param int[] $weightedValues
	 * @return mixed $key
	 */
	public static function getRandomWeightedElement(array $weightedValues){
		if (empty($weightedValues)){
			throw new PluginException("Config error! No sets exist in the config - don't you want to give the players anything?");
		}
		$rand = mt_rand(1, (int)array_sum($weightedValues));

		foreach ($weightedValues as $key => $value){
			$rand -= $value;
			if ($rand <= 0){
				return $key;
			}
		}
		return -1;
	}
}