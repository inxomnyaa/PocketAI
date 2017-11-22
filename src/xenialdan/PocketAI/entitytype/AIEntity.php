<?php

declare(strict_types=1);

namespace xenialdan\PocketAI\entitytype;

use pocketmine\block\Liquid;
use pocketmine\entity\Living;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\Player;
use xenialdan\PocketAI\EntityProperties;
use xenialdan\PocketAI\LootGenerator;
use xenialdan\PocketAI\SkillTree;

abstract class AIEntity extends Living{

	/** @var SkillTree */
	public $skillTree;
	/** @var LootGenerator */
	public $lootGenerator;
	/** @var EntityProperties */
	public $entityProperties;

	protected function initEntity(){
		parent::initEntity();

		$this->setSkillTree(new SkillTree($this));
		$this->setLootGenerator(new LootGenerator());
	}

	/**
	 * @return bool
	 */
	public function isInAir(): bool{
		return !$this->isOnGround() && !$this->isCollidedVertically && !$this->isInsideOfLiquid();//TODO check isCollidedVertically when sth above
	}

	public function isInsideOfLiquid(): bool{
		$block = $this->level->getBlock($this->temporalVector->setComponents(floor($this->x), floor($y = ($this->y + $this->getEyeHeight())), floor($this->z)));

		if ($block instanceof Liquid){
			$f = ($block->y + 1) - ($block->getFluidHeightPercent() - 0.1111111);
			return $y < $f;
		}

		return false;
	}

	public function generateRandomDirection(): Vector3{
		return new Vector3(mt_rand(-1000, 1000) / 1000, mt_rand(-500, 500) / 1000, mt_rand(-1000, 1000) / 1000);
	}

	public function getDrops(): array{
		$drops = $this->getLootGenerator()->getRandomLoot();
		return $drops;
	}

	public function getAdditionalSpawnData(){ }

	/**
	 * @param Player $player
	 */
	public function spawnTo(Player $player){
		$pk = new AddEntityPacket();
		$pk->entityRuntimeId = $this->getId();
		$pk->type = static::NETWORK_ID;
		$pk->position = $this->asVector3();
		$pk->motion = $this->getMotion();
		$pk->yaw = $this->yaw;
		$pk->pitch = $this->pitch;
		$pk->metadata = $this->dataProperties;
		$this->getAdditionalSpawnData();
		$player->dataPacket($pk);
		parent::spawnTo($player);
	}

	/**
	 * @return SkillTree
	 */
	public function getSkillTree(): SkillTree{
		return $this->skillTree;
	}

	/**
	 * @param SkillTree $skillTree
	 */
	public function setSkillTree(SkillTree $skillTree){
		$this->skillTree = $skillTree;
	}

	/**
	 * @return LootGenerator|null
	 */
	public function getLootGenerator(){
		return $this->lootGenerator;
	}

	/**
	 * @param null|LootGenerator $lootGenerator
	 */
	public function setLootGenerator(?LootGenerator $lootGenerator){
		$this->lootGenerator = $lootGenerator;
	}

	/**
	 * @return EntityProperties
	 */
	public function getEntityProperties(): EntityProperties{
		return $this->entityProperties;
	}

	/**
	 * @param EntityProperties $entityProperties
	 */
	public function setEntityProperties(EntityProperties $entityProperties){
		$this->entityProperties = $entityProperties;
	}
}