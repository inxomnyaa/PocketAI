<?php

declare(strict_types=1);

namespace xenialdan\PocketAI\entitytype;

use pocketmine\block\Liquid;
use pocketmine\entity\Attribute;
use pocketmine\entity\Entity;
use pocketmine\entity\Living;
use pocketmine\inventory\InventoryHolder;
use pocketmine\level\particle\HappyVillagerParticle;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\protocol\EntityEventPacket;
use pocketmine\timings\Timings;
use xenialdan\PocketAI\API;
use xenialdan\PocketAI\component\ComponentGroup;
use xenialdan\PocketAI\component\Components;
use xenialdan\PocketAI\component\minecraft\_leashable;
use xenialdan\PocketAI\EntityProperties;
use xenialdan\PocketAI\event\AddonEvent;
use xenialdan\PocketAI\inventory\AIEntityInventory;
use xenialdan\PocketAI\Loader;
use xenialdan\PocketAI\LootGenerator;

abstract class AIEntity extends Living implements InventoryHolder
{
    //Custom entries inside of the EntityProperties DataPropertyManager
    const DATA_PARENT_EID = 0;

    /** @var LootGenerator */
    public $lootGenerator;
    /** @var EntityProperties */
    public $entityProperties;
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

    public function isLeashed(): bool
    {
        return $this->getGenericFlag(self::DATA_FLAG_LEASHED);
    }

    /**
     * Leash entity to another entity. If passing null the entity will be unleashed
     * @param null|Entity $entity
     */
    public function setLeashedTo(?Entity $entity)
    {
        $this->getDataPropertyManager()->setLong(self::DATA_LEAD_HOLDER_EID, -1);
        /** @var Components $components */
        $components = $this->getEntityProperties()->findComponents("minecraft:leashable");
        if ($components->count() > 0) {
            /** @var _leashable $component */
            foreach ($components as $component) {
                if (is_null($entity)) {
                    if ($this->isLeashed()) {
                        $this->getLevel()->getServer()->getPluginManager()->callEvent($ev = new AddonEvent(Loader::getInstance(), API::targetToTest($this, $entity, $component->on_unleash["target"]), $component->on_unleash["event"]));
                    }
                    $this->getDataPropertyManager()->setLong(self::DATA_LEAD_HOLDER_EID, -1);
                    $this->setGenericFlag(self::DATA_FLAG_LEASHED, false);
                    $pk = new EntityEventPacket();
                    $pk->event = EntityEventPacket::REMOVE_LEASH;
                    $pk->entityRuntimeId = $this->getId();
                    $this->getLevel()->addGlobalPacket($pk);
                } else {
                    print_r($this->isLeashed() ? "Leashed" : "Not leashed");
                    if ($this->isLeashed()) $this->setLeashedTo(null);
                    print_r($this->isLeashed() ? "Leashed" : "Not leashed");
                    $this->getDataPropertyManager()->setLong(self::DATA_LEAD_HOLDER_EID, $entity->getId());
                    $this->setGenericFlag(self::DATA_FLAG_LEASHED, true);
                    print_r($this->isLeashed() ? "Leashed" : "Not leashed");
                    if ($this->isLeashed()) $this->getLevel()->getServer()->getPluginManager()->callEvent($ev = new AddonEvent(Loader::getInstance(), API::targetToTest($this, $entity, $component->on_leash["target"]), $component->on_leash["event"]));
                }
            }
        }
    }

    /* AI */
    public function entityBaseTick(int $tickDiff = 1): bool
    {
        Timings::$timerLivingEntityBaseTick->startTiming();

        $hasUpdate = parent::entityBaseTick($tickDiff);

        if ($this->isAlive()) {
            foreach (API::getAABBCorners($this->getBoundingBox()) as $corner) {
                $this->getLevel()->addParticle(new HappyVillagerParticle($corner));
            }
            /* behaviour checks */
        }

        Timings::$timerLivingEntityBaseTick->stopTiming();

        return $hasUpdate;
    }

    /* END AI */


    public function setWidth(float $width)
    {
        $this->width = $width;
        $this->propertyManager->setFloat(self::DATA_BOUNDING_BOX_WIDTH, $width);
        $this->recalculateBoundingBox();
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
        $this->eyeHeight = $this->height / 2 + 0.1;
        $this->propertyManager->setFloat(self::DATA_BOUNDING_BOX_HEIGHT, $height);
        $this->recalculateBoundingBox();
    }

    /** Overwriting due to float imprecision */
    protected function recalculateBoundingBox(): void
    {
        $this->boundingBox = (new AxisAlignedBB($this->getX(), $this->getY(), $this->getZ(), $this->getX(), $this->getY(), $this->getZ()))
            ->expand($this->width / 2, $this->height / 2, $this->width / 2)
            ->offset(0, $this->height / 2, 0);
    }

    /**
     * @return float
     */
    public function getHeight(): float
    {
        return $this->height;
    }

    /**
     * Returns the entity ID of the entity's current parent, or null if it doesn't have a parent.
     * @return int|null
     */
    public function getParentEntityId(): ?int
    {
        return $this->getEntityProperties()->getLong(self::DATA_PARENT_EID);
    }

    /**
     * Returns the entity's current parent entity, or null if not found.
     * @return Entity|null
     */
    public function getParentEntity(): ?Entity
    {
        $eid = $this->getParentEntityId();
        if ($eid !== null) {
            return $this->server->findEntity($eid);
        }

        return null;
    }

    /**
     * Sets the entity's current parent entity. Passing null will remove the current parent.
     *
     * @param Entity|null $parent
     *
     * @throws \InvalidArgumentException if the parent entity is not valid
     */
    public function setParentEntity(?Entity $parent): void
    {
        if ($parent === null) {
            $this->getEntityProperties()->removeProperty(self::DATA_PARENT_EID);
        } elseif ($parent->closed) {
            throw new \InvalidArgumentException("Supplied parent entity is garbage and cannot be used");
        } else {
            $this->getEntityProperties()->setLong(self::DATA_PARENT_EID, $parent->getId());
        }
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
     * @return AIEntityInventory|null
     */
    public function getInventory(): ?AIEntityInventory
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

    public function saveNBT(): CompoundTag
    {//TODO properly fix
        $nbt = parent::saveNBT();
        $activeComponents = new CompoundTag("components");
        /** @var ComponentGroup $activeComponentGroup */
        foreach ($this->getEntityProperties()->getActiveComponentGroups() as $activeComponentGroup) {
            $activeComponents->setByte($activeComponentGroup->getName(), 1);
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
     * @param null|EntityProperties $entityProperties
     */
    public function setEntityProperties(?EntityProperties $entityProperties)
    {
        //TODO remove current properties
        $this->entityProperties = $entityProperties;
        if (!is_null($entityProperties))
            $this->entityProperties->applyComponents();
    }
}