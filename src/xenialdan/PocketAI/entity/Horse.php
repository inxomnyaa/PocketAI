<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

declare(strict_types=1);

namespace xenialdan\PocketAI\entity;

use pocketmine\entity\Attribute;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\inventory\InventoryHolder;
use pocketmine\math\Vector3;
use xenialdan\PocketAI\EntityProperties;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\event\AddonEvent;
use xenialdan\PocketAI\interfaces\Rideable;
use xenialdan\PocketAI\interfaces\Tamable;
use xenialdan\PocketAI\Loader;

class Horse extends AIEntity implements Rideable, Tamable, InventoryHolder{
	const NETWORK_ID = self::HORSE;

	/** @var Vector3 */
	public $direction = null;

	public function initEntity(){
		$this->setEntityProperties(new EntityProperties("entities/horse", $this));
		parent::initEntity();

		// TODO: remove - just for testing purposes
		//Temp auto-tame
		Loader::getInstance()->getServer()->getPluginManager()->callEvent($ev = new AddonEvent(Loader::getInstance(), $this, "minecraft:on_tame"));
		#$this->setDataFlag(self::DATA_FLAGS, self::DATA_FLAG_TAMED, true);
		$this->setDataFlag(self::DATA_FLAGS, self::DATA_FLAG_WASD_CONTROLLED, true);
		$this->setDataFlag(self::DATA_FLAGS, self::DATA_FLAG_CAN_POWER_JUMP, true);
		$this->setDataFlag(self::DATA_FLAGS, self::DATA_FLAG_SADDLED, true);
		#$this->setDataFlag(self::DATA_FLAGS, self::DATA_FLAG_HAS_COLLISION, true);

	}

	protected function addAttributes(){
		$this->attributeMap->addAttribute(Attribute::getAttribute(Loader::HORSE_JUMP_POWER));
		parent::addAttributes();
	}

	public function getName(): string{
		return "Horse";
	}

	public function attack(EntityDamageEvent $source){
		parent::attack($source);
	}

	public function entityBaseTick(int $tickDiff = 1): bool{
		if ($this->closed !== false){
			return false;
		}
		$hasUpdate = parent::entityBaseTick($tickDiff);
		return $hasUpdate;
	}

	protected function applyGravity(){
		if ($this->isInAir()){
			parent::applyGravity();
		}
	}

	public function isTamed(): bool{
		return $this->getGenericFlag(self::DATA_FLAG_TAMED);
	}

	/**
	 * @param bool $value
	 */
	public function setTamed(bool $value = true){
		$this->setGenericFlag(self::DATA_FLAG_TAMED, $value);
	}

	/**
	 * @return bool
	 */
	public function isSitting(): bool{
		return $this->getGenericFlag(self::DATA_FLAG_SITTING);
	}

	/**
	 * @param bool $value
	 */
	public function setSitting(bool $value = true){
		$this->setGenericFlag(self::DATA_FLAG_SITTING, $value);
	}
}
