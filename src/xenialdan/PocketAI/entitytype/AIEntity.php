<?php

declare(strict_types=1);

namespace xenialdan\PocketAI\entitytype;

use pocketmine\block\Liquid;
use pocketmine\entity\Attribute;
use pocketmine\entity\Living;
use pocketmine\level\particle\RedstoneParticle;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use xenialdan\PocketAI\EntityProperties;
use xenialdan\PocketAI\inventory\AIEntityInventory;
use xenialdan\PocketAI\LootGenerator;

abstract class AIEntity extends Living
{

    /** @var LootGenerator */
    public $lootGenerator;
    /** @var EntityProperties */
    public $entityProperties;
    /** @var float */
    public $baseSpeed = 0.0;
    /** @var int */
    public $seatCount = 0;
    /** @var array */
    public $seats = [];
    /** @var AIEntityInventory|null */
    public $inventory;

    public $width = 0.0;
    public $height = 0.0;

    public $jumpVelocity = 0.42;

    protected function initEntity(CompoundTag $nbt): void
    {
        parent::initEntity($nbt);

        $this->setLootGenerator(new LootGenerator());
    }

    /* AI */

    public function entityBaseTick(int $tickDiff = 1): bool
    {
        $this->getLevel()->addParticle(new RedstoneParticle($this->asVector3()));

        if (!$this->closed) {
            return false;
        }

        $hasUpdate = parent::entityBaseTick($tickDiff);

        if ($this->isAlive()) {
            /* behaviour checks */

        }

        return $hasUpdate;
    }

    /* END AI */


    public function setWidth(float $width)
    {
        $this->width = $width;
        $this->propertyManager->setFloat(self::DATA_BOUNDING_BOX_WIDTH, $width);
    }

    /**
     * @return float
     */
    public function getWidth(): float
    {
        return $this->width;
    }

    public function setHeight(float $height)
    {
        $this->height = $height;
        $this->propertyManager->setFloat(self::DATA_BOUNDING_BOX_HEIGHT, $height);
    }

    /**
     * @return float
     */
    public function getHeight(): float
    {
        return $this->height;
    }

    /**
     * @return float
     */
    public function getDefaultSpeed(): float
    {
        return $this->getAttributeMap()->getAttribute(Attribute::MOVEMENT_SPEED)->getValue();
    }

    /**
     * @param float $base
     */
    public function setDefaultSpeed(float $base)
    {
        $this->getAttributeMap()->getAttribute(Attribute::MOVEMENT_SPEED)->setDefaultValue($base);
    }

    /**
     * @return float
     */
    public function getDefaultAttackDamage(): float
    {
        return $this->getAttributeMap()->getAttribute(Attribute::ATTACK_DAMAGE)->getValue();
    }

    /**
     * @param int $base
     */
    public function setDefaultAttackDamage(int $base)
    {
        $this->getAttributeMap()->getAttribute(Attribute::ATTACK_DAMAGE)->setDefaultValue($base);
    }

    /**
     * @return int
     */
    public function getDefaultFollowRange(): int
    {
        return intval($this->getAttributeMap()->getAttribute(Attribute::FOLLOW_RANGE)->getValue());
    }

    /**
     * @param float $base
     */
    public function setDefaultFollowRange(float $base)
    {
        $this->getAttributeMap()->getAttribute(Attribute::FOLLOW_RANGE)->setDefaultValue($base);
    }

    /**
     * @return float
     */
    public function getDefaultKnockbackResistance(): float
    {
        return $this->getAttributeMap()->getAttribute(Attribute::KNOCKBACK_RESISTANCE)->getValue();
    }

    /**
     * @param float $base
     */
    public function setDefaultKnockbackResistance(float $base)
    {
        $this->getAttributeMap()->getAttribute(Attribute::KNOCKBACK_RESISTANCE)->setDefaultValue($base);
    }

    /**
     * @return int
     */
    public function getSeatCount(): int
    {
        return $this->seatCount;
    }

    /**
     * @param int $seatCount
     */
    public function setSeatCount(int $seatCount)
    {
        $this->seatCount = $seatCount;
    }

    /**
     * @return array
     */
    public function getSeats(): array
    {
        return $this->seats;
    }

    /**
     * @param array $seats
     */
    public function setSeats(array $seats)
    {
        $this->seats = $seats;
    }

    /**
     * @return AIEntityInventory
     */
    public function getInventory(): AIEntityInventory
    {
        return $this->inventory;
    }

    /**
     * @param AIEntityInventory $inventory
     */
    public function setInventory(AIEntityInventory $inventory)
    {
        $this->inventory = $inventory;
    }

    public function getDrops(): array
    {
        $drops = $this->getLootGenerator()->getRandomLoot();
        return $drops;
    }

    /*public function getAdditionalSpawnData()
    {//TODO properly fix
        $activeComponents = $this->namedtag->getCompoundTag("components") ?? [];
        /** @var ByteTag $activeComponent * /
        foreach ($activeComponents as $activeComponent) {
            if ($activeComponent->getValue() !== 0) $this->getEntityProperties()->addActiveComponentGroup($activeComponent->getName());
        }
    }*/

    public function saveNBT(): CompoundTag
    {//TODO properly fix
        $nbt = parent::saveNBT();
        $activeComponents = new CompoundTag("components");
        foreach ($this->getEntityProperties()->getActiveComponentGroups() as $activeComponentGroupName => $activeComponentGroupValue) {
            $activeComponents->setByte($activeComponentGroupName, 1);
        }
        $nbt->setTag($activeComponents);
        return $nbt;
    }

    /**
     * @return bool
     */
    public function isInAir(): bool
    {
        return !$this->isOnGround() && !$this->isCollidedVertically && !$this->isInsideOfLiquid();//TODO check isCollidedVertically when sth above
    }

    public function isInsideOfLiquid(): bool
    {
        $block = $this->level->getBlock($this->temporalVector->setComponents(floor($this->x), floor($y = ($this->y + $this->getEyeHeight())), floor($this->z)));

        if ($block instanceof Liquid) {
            $f = ($block->y + 1) - ($block->getFluidHeightPercent() - 0.1111111);
            return $y < $f;
        }

        return false;
    }

    public function generateRandomDirection(): Vector3
    {
        return new Vector3(mt_rand(-1000, 1000) / 1000, mt_rand(-500, 500) / 1000, mt_rand(-1000, 1000) / 1000);
    }

    /**
     * @return LootGenerator|null
     */
    public function getLootGenerator()
    {
        return $this->lootGenerator;
    }

    /**
     * @param null|LootGenerator $lootGenerator
     */
    public function setLootGenerator(?LootGenerator $lootGenerator)
    {
        $this->lootGenerator = $lootGenerator;
    }

    /**
     * @return null|EntityProperties
     */
    public function getEntityProperties(): ?EntityProperties
    {
        return $this->entityProperties;
    }

    /**
     * @param EntityProperties $entityProperties
     */
    public function setEntityProperties(EntityProperties $entityProperties)
    {
        $this->entityProperties = $entityProperties;
    }
}