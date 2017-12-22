<?php

declare(strict_types=1);

namespace xenialdan\PocketAI\item;

use pocketmine\block\Block;
use pocketmine\entity\Entity;
use pocketmine\entity\projectile\Projectile;
use pocketmine\event\entity\ProjectileLaunchEvent;
use pocketmine\item\Tool;
use pocketmine\level\Level;
use pocketmine\level\sound\LaunchSound;
use pocketmine\math\Vector3;
use pocketmine\Player;
use xenialdan\PocketAI\entity\FishingHook;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;
use xenialdan\PocketAI\event\entity\EntityCastRodEvent;
use xenialdan\PocketAI\event\entity\EntityReelRodEvent;
use xenialdan\PocketAI\Loader;
use xenialdan\PocketAI\LootGenerator;

class FishingRod extends Tool{

	public function __construct(int $meta = 0){
		parent::__construct(self::FISHING_ROD, $meta, "Fishing Rod");
	}

	public function getMaxDurability(){
		return 65;
	}

	public function onClickAir(Player $player, Vector3 $directionVector): bool{
		var_dump($this->isCasted($player));
		if (!$this->isCasted($player)){
			$nbt = Entity::createBaseNBT(
				$player->add(0, $player->getEyeHeight(), 0),
				$directionVector,
				($player->yaw > 180 ? 360 : 0) - $player->yaw,
				-$player->pitch
			);

			$diff = $player->getItemUseDuration();

			$entity = Entity::createEntity("pocketai:fishing_hook", $player->getLevel(), $nbt, $player);
			if ($entity instanceof AIProjectile){
				$force = 0.8;
				$ev = new EntityCastRodEvent($player, $this, $entity, $force);

				if ($diff < 5){
					$ev->setCancelled();
				}

				$player->getServer()->getPluginManager()->callEvent($ev);

				$entity = $ev->getProjectile(); //This might have been changed by plugins

				if ($ev->isCancelled()){
					$entity->flagForDespawn();
					$player->getInventory()->sendContents($player);
				} else{
					$entity->setMotion($entity->getMotion()->multiply($ev->getForce()));
					$player->getServer()->getPluginManager()->callEvent($projectileEv = new ProjectileLaunchEvent($entity));
					if ($projectileEv->isCancelled()){
						$ev->getProjectile()->flagForDespawn();
					} else{
						$this->setHook($player, $projectileEv->getEntity());
						$projectileEv->getEntity()->spawnToAll();
						$player->level->addSound(new LaunchSound($player), $player->getViewers());
					}
				}
			} else{
				$entity->spawnToAll();
			}
			return false;
		} else{
			if ($this->getHook($player) instanceof Projectile){
				$force = 0.8;
				$ev = new EntityReelRodEvent($player, $this, $this->getHook($player), $force);

				$player->getServer()->getPluginManager()->callEvent($ev);

				$entity = $ev->getProjectile();

				if ($ev->isCancelled()){
					$player->getInventory()->sendContents($player);
				} else{
					if ($entity instanceof AIProjectile){
						if ($this->getHook($player)->isHooked()){
							$loot = new LootGenerator("loot_tables/gameplay/fishing.json", $entity);//TODO enchantments
							$items = $loot->getRandomLoot();
							//TODO motion
							//TODO if linked/hooked: pull entities
							foreach ($items as $item){
								$entity->getLevel()->dropItem($entity->asVector3(), $item, null, 0);
							}
						}
					}
					$entity->flagForDespawn();
					$this->setHook($player,null);
					//TODO if linked/hooked: Mobs 5 damage, Items 2 damage, fishing 1 damage
					$this->applyDamage(1);
					return true;
				}
			}
			return false;
		}
	}

	/**
	 * @param Player $player
	 * @return bool
	 */
	public function isCasted(Player $player): bool{
		return $this->getHook($player) instanceof FishingHook;
	}

	/**
	 * @param Player $player
	 * @return null|FishingHook
	 */
	public function getHook(Player $player){
		return Loader::getHook($player);
	}

	/**
	 * @param Player $player
	 * @param null|FishingHook $hook
	 */
	public function setHook(Player $player, ?FishingHook $hook){
		return Loader::setHook($player, $hook);
	}
}