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

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\Item;
use pocketmine\item\Item as ItemItem;
use pocketmine\math\Vector3;
use xenialdan\PocketAI\EntityProperties;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\LootGenerator;
use xenialdan\PocketAI\SkillTree;

class Cow extends AIEntity{
	const NETWORK_ID = self::COW;

	/** @var float */
	public $height = 0.9;
	/** @var float */
	public $width = 1.3;

	/** @var Vector3 */
	public $direction = null;
	public $speed = 0.1 * 3;

	public function initEntity(){
		$this->setMaxHealth(10);
		parent::initEntity();

		$this->getSkillTree()->addSkills(SkillTree::SKILL_WALK, SkillTree::SKILL_JUMP);
		$this->setEntityProperties(new EntityProperties("entities/cow.json", $this));
		$this->getEntityProperties()->getActiveComponentGroups();
		$this->setLootGenerator(new LootGenerator("loot_tables/entities/cow.json", $this));//TODO get from EntityProperties
	}

	public function getName(): string{
		return "Cow";
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

	/**
	 * @return ItemItem
	 */
	public function getFeedingItem(): ItemItem{
		return ItemItem::get(ItemItem::WHEAT);//TODO
	}
}
