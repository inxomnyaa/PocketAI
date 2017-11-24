<?php

namespace xenialdan\PocketAI;

use pocketmine\plugin\PluginException;
use xenialdan\PocketAI\entitytype\AIEntity;

class EntityProperties{
	private $behaviour = "empty";
	/** @var null|AIEntity */
	private $entity;
	private $behaviourFile = [];
	/** @var array */
	public $componentGroups = [];

	/**
	 * EntityProperties constructor.
	 * @param string $behaviour
	 * @param AIEntity|null $entity
	 */
	public function __construct(string $behaviour, AIEntity $entity = null){
		$behaviour = str_replace(".json", "", $behaviour);
		if (!array_key_exists($behaviour, Loader::$behaviour)) throw new \InvalidArgumentException("Entity behaviour/properties file: " . $behaviour . " not found" . (is_null($entity) ? "" : " for entity of type " . $entity->getName()));
		$this->behaviour = $behaviour;
		$this->behaviourFile = Loader::$behaviour[$this->behaviour];
		if (version_compare($this->behaviourFile["minecraft:entity"]["format_version"] ?? "1.2.0", "1.2.0") !== 0){
			throw new \InvalidArgumentException("The Entity behaviour/properties file: " . $behaviour . " has an unsupported format_version and will not be used");
		}
		$this->entity = $entity;
		$this->entity->setLootGenerator(new LootGenerator($this->getLootTableName(), $this->entity) ?? new LootGenerator(null, $this->entity));
	}

	/**
	 * @return array
	 */
	public function getBehaviours(): array{
		return $this->behaviourFile;
	}

	public function getBehaviourComponentGroups(){
		return $this->behaviourFile["minecraft:entity"]["component_groups"];
	}

	public function getBehaviourComponentGroup(string $component_group_name){
		return $this->getBehaviourComponentGroups()[$component_group_name] ?? null;
	}

	public function getBehaviourComponents(){
		var_dump("============ BEHAVIOUR COMPONENTS ============");
		var_dump(array_keys($this->behaviourFile["minecraft:entity"]["components"]));
		return $this->behaviourFile["minecraft:entity"]["components"];
	}

	public function getBehaviourEvents(){
		return $this->behaviourFile["minecraft:entity"]["events"];
	}

	public function getActiveComponentGroups(){
		var_dump("============ ACTIVE GROUPS ============");
		var_dump(array_keys($this->componentGroups));
		return $this->componentGroups;
	}

	public function addActiveComponentGroup(string $component_group_name){
		var_dump("============ ADD GROUP NAME ============");
		var_dump($component_group_name);
		if (!is_null(($component_group = $this->getBehaviourComponentGroup($component_group_name)))){
			$this->componentGroups[$component_group_name] = $component_group;
			var_dump("============ ADDED COMPONENT GROUP ============");
			var_dump($component_group);
			$this->entity->setLootGenerator(new LootGenerator($this->getLootTableName(), $this->entity) ?? new LootGenerator(null, $this->entity));
		}
		$this->getActiveComponentGroups();
	}

	public function removeActiveComponentGroup(string $component_group_name){
		//TODO set the groups properties
		unset($this->componentGroups[$component_group_name]);
	}

	/* "API"-alike part */

	/**
	 * @return string
	 */
	public function getLootTableName(){
		var_dump("============ GETLOOTTABLENAME ============");
		$default = "loot_tables/empty.json";
		$this->getActiveComponentGroups();
		foreach ($this->getActiveComponentGroups() as $activeComponentGroup => $activeComponentGroupData){
			var_dump("============ ACTIVECOMPONENTGROUP ============");
			var_dump($activeComponentGroup);
			var_dump($activeComponentGroupData);
			if (isset($activeComponentGroupData["minecraft:loot"]) && isset($activeComponentGroupData["minecraft:loot"]["table"])) return $activeComponentGroupData["minecraft:loot"]["table"];
		}
		if (isset($this->getBehaviourComponents()["minecraft:loot"]) && isset($this->getBehaviourComponents()["minecraft:loot"]["table"])) return $this->getBehaviourComponents()["minecraft:loot"]["table"];
		return $default;
	}

	public function applyEvent($behaviourEvent_data){
		var_dump("============ EVENT DATA ============");
		var_dump($behaviourEvent_data);
		foreach ($behaviourEvent_data as $function => $function_properties){
			var_dump("============ EVENT ============");
			var_dump($function);
			switch ($function){
				case "randomize": {
					$array = [];
					foreach ($function_properties as $index => $property){
						$array[] = $property["weight"] ?? 1;
					}
					//TODO temp fix, remove when fixed
					$subEvents = $function_properties[$this->getRandomWeightedElement($array)];
					$this->applyEvent($subEvents);
					break;
				}
				case "add": {
					foreach ($function_properties as $function_property => $function_property_data){
						switch ($function_property){
							case "component_groups": {
								foreach ($function_property_data as $componentgroup){
									$this->addActiveComponentGroup($componentgroup);
								}
								break;
							}
							default: {
								$this->entity->getLevel()->getServer()->getLogger()->notice("Function \"" . $function_property . "\" for add component events is not coded into the plugin yet");
							}
						}
					}
					break;
				}
				case "remove": {
					foreach ($function_properties as $function_property => $function_property_data){
						switch ($function_property){
							case "component_group": {
								foreach ($function_property_data as $componentgroup){
									$this->removeActiveComponentGroup($componentgroup);
								}
								break;
							}
							default: {
								$this->entity->getLevel()->getServer()->getLogger()->notice("Function \"" . $function_property . "\" for add component events is not coded into the plugin yet");
							}
						}
					}
					break;
				}
				case "weight": {
					//just a property, ignore it
					break;
				}
				default: {
					$this->entity->getLevel()->getServer()->getLogger()->notice("Function \"" . $function . "\" for behaviour events is not coded into the plugin yet");
				}
			}
		}
	}

	/* HELPER FUNCTIONS */
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