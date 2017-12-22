<?php

declare(strict_types=1);

namespace xenialdan\PocketAI\event\entity;

use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityEvent;
use pocketmine\entity\Living;
use pocketmine\entity\projectile\Projectile;
use pocketmine\event\Cancellable;
use pocketmine\item\Item;

class EntityCastRodEvent extends EntityEvent implements Cancellable{
	public static $handlerList = null;

	/** @var Item */
	private $rod;
	/** @var Projectile */
	private $projectile;
	/** @var float */
	private $force;

	/**
	 * @param Living $shooter
	 * @param Item $rod
	 * @param Projectile $projectile
	 * @param float $force
	 */
	public function __construct(Living $shooter, Item $rod, Projectile $projectile, float $force){
		$this->entity = $shooter;
		$this->rod = $rod;
		$this->projectile = $projectile;
		$this->force = $force;
	}

	/**
	 * @return Living
	 */
	public function getEntity(){
		return $this->entity;
	}

	/**
	 * @return Item
	 */
	public function getRod() : Item{
		return $this->rod;
	}

	/**
	 * Returns the entity considered as the projectile in this event.
	 *
	 * NOTE: This might not return a Projectile if a plugin modified the target entity.
	 *
	 * @return Entity
	 */
	public function getProjectile() : Entity{
		return $this->projectile;
	}

	/**
	 * @param Entity $projectile
	 */
	public function setProjectile(Entity $projectile){
		if($projectile !== $this->projectile){
			if(count($this->projectile->getViewers()) === 0){
				$this->projectile->kill();
				$this->projectile->close();
			}
			$this->projectile = $projectile;
		}
	}

	/**
	 * @return mixed
	 */
	public function getForce(){
		return $this->force;
	}

	/**
	 * @param mixed $force
	 */
	public function setForce($force){
		$this->force = $force;
	}
}