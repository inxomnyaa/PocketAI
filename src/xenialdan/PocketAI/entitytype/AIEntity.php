<?php

declare(strict_types=1);

namespace xenialdan\PocketAI\entitytype;

use pocketmine\block\Liquid;
use pocketmine\entity\Attribute;
use pocketmine\entity\Entity;
use pocketmine\entity\Living;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\inventory\InventoryHolder;
use pocketmine\item\Durable;
use pocketmine\item\Item;
use pocketmine\level\particle\HappyVillagerParticle;
use pocketmine\level\particle\RedstoneParticle;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\protocol\EntityEventPacket;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\Player;
use salmonde\pathfinding\Pathfinder;
use salmonde\pathfinding\PathResult;
use salmonde\pathfinding\utils\validator\JumpHeightValidator;
use xenialdan\PocketAI\ai\AIManager;
use xenialdan\PocketAI\API;
use xenialdan\PocketAI\component\ComponentGroup;
use xenialdan\PocketAI\component\Components;
use xenialdan\PocketAI\component\minecraft\_interact;
use xenialdan\PocketAI\component\minecraft\_leashable;
use xenialdan\PocketAI\entity\LeashKnot;
use xenialdan\PocketAI\EntityProperties;
use xenialdan\PocketAI\event\AddonEvent;
use xenialdan\PocketAI\filter\Filters;
use xenialdan\PocketAI\inventory\AIEntityInventory;
use xenialdan\PocketAI\item\Lead;
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

    /** @var AIManager */
    public $aiManager;
    /** @var PathResult|null */
    private $path = null;

    protected function initEntity(/*CompoundTag $nbt*/): void
    {
        parent::initEntity(/*$nbt*/);


        $this->setLootGenerator(new LootGenerator());
    }

    public function isLeashed(): bool
    {
        return $this->getGenericFlag(self::DATA_FLAG_LEASHED);
    }

    /**
     * Leash entity to another entity. If passing null the entity will be unleashed
     * @param null|Entity $entity
     * @throws \ReflectionException
     */
    public function setLeashedTo(?Entity $entity)
    {
        //$this->getDataPropertyManager()->setLong(self::DATA_LEAD_HOLDER_EID, -1);
        if (is_null($this->getEntityProperties())) return;
        /** @var Components $components */
        $components = $this->getEntityProperties()->findComponents("minecraft:leashable");
        if ($components->count() > 0) {
            /** @var _leashable $component */
            foreach ($components as $component) {
                if (is_null($entity)) {
                    if ($this->isLeashed()) {
                        (new AddonEvent(Loader::getInstance(), API::targetToTest($this, $entity, $component->on_unleash["target"]), $component->on_unleash["event"]))->call();
                    }
                    $this->getDataPropertyManager()->setLong(self::DATA_LEAD_HOLDER_EID, -1);
                    $this->setGenericFlag(self::DATA_FLAG_LEASHED, false);
                    $pk = new EntityEventPacket();
                    $pk->event = EntityEventPacket::REMOVE_LEASH;
                    $pk->entityRuntimeId = $this->getId();
                    $this->getLevel()->broadcastGlobalPacket($pk);
                } else {
                    print "\n\n";
                    print_r($this->isLeashed() ? "Leashed" : "Not leashed");
                    print "\n";
                    //if ($this->isLeashed()) $this->setLeashedTo(null);
                    //print "\n";
                    // print_r($this->isLeashed() ? "Leashed" : "Not leashed");
                    // print "\n";
                    $this->getDataPropertyManager()->setLong(self::DATA_LEAD_HOLDER_EID, $entity->getId());
                    $this->setGenericFlag(self::DATA_FLAG_LEASHED, true);
                    print "\n";
                    print_r($this->isLeashed() ? "Leashed" : "Not leashed");
                    print "\n";
                    if ($this->isLeashed()) (new AddonEvent(Loader::getInstance(), API::targetToTest($this, $entity, $component->on_leash["target"]), $component->on_leash["event"]))->call();
                }
            }
        }
    }

    /**
     * @return null|Entity
     */
    public function getLeadHolder()
    {
        return $this->getLevel()->getServer()->findEntity($this->getDataPropertyManager()->getLong(self::DATA_LEAD_HOLDER_EID));
    }

    /* AI */
    public function entityBaseTick(int $tickDiff = 1): bool
    {

        $hasUpdate = parent::entityBaseTick($tickDiff);

        if ($this->isAlive()) {
            foreach (API::getAABBCorners($this->getBoundingBox()) as $corner) {
                $this->getLevel()->addParticle(new HappyVillagerParticle($corner));
            }
            if ($this->ticksLived % 20 * 30 === 0) {
                if (is_null(($target = $this->getTargetEntity()))) {
                    $this->path = null;
                } else {
                    $pathfinder = new Pathfinder($this->level, $this->floor(), $this->getTargetEntity()->floor(), $this->getBoundingBox() ?? null);
                    $pathfinder->getAlgorithm()->addValidator(new JumpHeightValidator($pathfinder->getAlgorithm()->getLowestValidatorPriority() - 1, 1));
                    $this->getLevel()->getServer()->getLogger()->debug('[A*] Calculating ...');
                    $pathfinder->findPath();
                    $this->getLevel()->getServer()->getLogger()->debug('[A*] Done.');
                    $this->path = $pathfinder->getPathResult();
                    if ($this->path === null)
                        $this->getLevel()->getServer()->getLogger()->debug('[A*] Null.');
                    $this->getLevel()->getServer()->getLogger()->debug('[A*] Done.');
                }
            }

            if (!is_null($this->path) && ($this->path) instanceof PathResult) {
                $cpypth = $this->path;
                foreach ($cpypth as $block) {
                    $this->getLevel()->addParticle(new RedstoneParticle($block->add(0.5, 0, 0.5)));
                }
                $this->checkBlockCollision();
                $this->path->rewind();
                /** @var Vector3 */
                $current = $this->path->current();
                if ($this->path->getNextPosition()->getY() > $this->getY() && $this->isOnGround() && $this->isCollidedVertically)
                    $this->jump();
                $delta = $current->add($this->getWidth() / 2, 0, $this->getWidth())->subtract($this)->normalize()->multiply($this->getAttributeMap()->getAttribute(Attribute::MOVEMENT_SPEED)->getValue() * $tickDiff);
                $this->setMotion($delta);

                /*if($this->floor()->equals($current->floor())){//TODO wtf
                    $this->path = $this->path->getPredecessor();
                }*/
            }
        }

        return $hasUpdate;
    }

    public function attack(EntityDamageEvent $source): void
    {
        if ($source instanceof EntityDamageByEntityEvent) {
            $this->setTargetEntity($source->getDamager());
        }
    }

    protected function applyGravity(): void
    {
        if ($this->getEntityProperties()->hasComponent("minecraft:physics")) {
            parent::applyGravity();
        }
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

    public function saveNBT()/*: CompoundTag*/
    : void
    {//TODO properly fix
        #$nbt = parent::saveNBT();
        $activeComponents = new CompoundTag("components");
        /** @var ComponentGroup $activeComponentGroup */
        if (!is_null($this->getEntityProperties())) {
            foreach ($this->getEntityProperties()->getActiveComponentGroups() as $activeComponentGroup) {
                $activeComponents->setByte($activeComponentGroup->getName(), 1);
            }
        }
        #$nbt->setTag($activeComponents);
        #return $nbt;
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

    //INTERACTIONS

    /**
     * @param Player $player
     * @return bool
     * @throws \ReflectionException
     */
    public function onRightClick(Player $player): bool
    {
        $entityProperties = $this->getEntityProperties();
        if (is_null($entityProperties)) return false;
        //leashing start
        if ($this->isLeashed()) {
            if ($this->getEntityProperties()->hasComponent("minecraft:leashable")) {
                $holder = $this->getLeadHolder();
                if ($holder instanceof LeashKnot) $holder->kill();
                elseif ($holder->getId() === $player->getId()) {
                    $this->getLevel()->dropItem($this, new Lead());
                    $this->setLeashedTo(null);
                }
                return true;
            } else {
                $this->setGenericFlag(self::DATA_FLAG_LEASHED, false);
                $this->getDataPropertyManager()->setLong(self::DATA_LEAD_HOLDER_EID, -1);
            }
        }
        //leashing end
        switch ($player->getInventory()->getItemInHand()->getId()) {
            case Item::LEAD:
                {
                    if ($this->getEntityProperties()->hasComponent("minecraft:leashable")) {
                        if (!$this->isLeashed()) {
                            $player->getInventory()->getItemInHand()->pop();
                            $this->setLeashedTo($player);
                        }
                    }
                    break;
                }
            default:
                {
                    /** @var Components $components */
                    $components = $this->getEntityProperties()->findComponents("minecraft:interact");
                    if ($components->count() > 0) {
                        /** @var _interact $component */
                        foreach ($components as $component) {
                            $on_interact_positive = true;
                            if (is_array($component->on_interact)) {//TODO event class
                                foreach ($component->on_interact as $key => $value) {
                                    if ($key === "filters") {//TODO move filter checks to seperate class
                                        $filters = new Filters($value);
                                        $on_interact_positive = $filters->test($this, $player);
                                        Loader::getInstance()->getLogger()->notice("All on_interact filters completed with result: " . ($on_interact_positive ? "YES" : "NO"));
                                    }
                                }
                            }
                            if ($on_interact_positive) {//TODO optimise

                                $itemStackInHand = $player->getInventory()->getItemInHand();
                                /** @var Item|null $addItem */
                                $addItem = null;
                                try {
                                    $itemInHand = (clone $itemStackInHand)->pop();
                                } catch (\InvalidArgumentException $e) {
                                    $itemInHand = new Item(Item::AIR);
                                }
                                try {
                                    if (!is_null($component->use_item) && $component->use_item) {
                                        $itemStackInHand->pop();
                                    }
                                    if (!is_null($component->hurt_item) && $itemInHand instanceof Durable) {
                                        $itemInHand->applyDamage($component->hurt_item);
                                    }
                                    if (!is_null($component->play_sounds)) {
                                        foreach (explode(",", $component->play_sounds) as $sound) {//TODO find seperator - no multi-sounds in vanilla behaviours
                                            $pk = new LevelSoundEventPacket();
                                            $pk->sound = constant(get_class($pk) . "::SOUND_" . strtoupper(trim($sound)));
                                            $pk->position = $this->asVector3();
                                            $player->sendDataPacket($pk);
                                        }
                                    }
                                    if (!is_null($component->transform_to_item) && ($item = Item::fromString($component->transform_to_item)) instanceof Item) {
                                        $addItem = $item;
                                    }
                                } catch (\InvalidArgumentException $e) {
                                    //Logger: warning -> x component failed to succeed due to an error in parsing the json script in x aientity with x player
                                    return false;//Abort interaction to remain items even though the component data was invalid
                                }
                                if ($itemStackInHand->isNull()) {
                                    if (!is_null($addItem) && !$addItem->isNull()) {
                                        $player->getInventory()->setItemInHand($addItem);
                                    }
                                } else {
                                    if (!is_null($addItem) && !$addItem->isNull()) {
                                        $player->getInventory()->addItem($addItem);
                                    }
                                    $player->getInventory()->setItemInHand($itemStackInHand);
                                }
                                if (!$itemInHand->equals($itemStackInHand, true, true)) {
                                    $player->getInventory()->addItem($itemInHand);
                                }

                            }
                        }
                        return true;
                    }
                }
        }
        return false;
    }

    public function onInventoryOpen(InventoryHolder $inventoryHolder, Player $player)
    { //TODO other entities
        if ($inventoryHolder instanceof AIEntity && !is_null($inventoryHolder->getInventory())) {
            var_dump($inventoryHolder->getInventory()->getName());
            var_dump($inventoryHolder->getInventory()->getNetworkType());
            $player->addWindow($inventoryHolder->getInventory());
            return true;
        }
        return false;
    }

    public function onHover(AIEntity $target, Player $player): bool//TODO fix hover calling with old item when changing slot
    {
        $player->getDataPropertyManager()->setString(Entity::DATA_INTERACTIVE_TAG, "");//remove button text
        /** @var Components $components */
        $entityProperties = $target->getEntityProperties();
        if (is_null($entityProperties)) return false;
        $components = $entityProperties->findComponents("minecraft:interact");
        if ($components->count() > 0) {
            /** @var _interact $component */
            foreach ($components as $component) {
                $on_interact_positive = true;
                if (is_array($component->on_interact)) {//TODO event class
                    foreach ($component->on_interact as $key => $value) {
                        if ($key === "filters") {
                            $filters = new Filters($value);
                            $on_interact_positive = $filters->test($target, $player);
                            Loader::getInstance()->getLogger()->notice("All on_interact filters completed with result: " . ($on_interact_positive ? "YES" : "NO"));
                        }
                    }
                }
                if (!$on_interact_positive) return false;
                $player->sendTip($component->interact_text ?? "");//TODO remove debug
                $player->getDataPropertyManager()->setString(Entity::DATA_INTERACTIVE_TAG, $component->interact_text ?? "");
            }
            return true;
        }
        return false;
    }
}