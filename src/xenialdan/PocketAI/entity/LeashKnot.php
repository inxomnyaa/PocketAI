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

use pocketmine\block\Fence;
use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\item\Lead;

class LeashKnot extends AIEntity
{
    const NETWORK_ID = self::LEASH_KNOT;

    /** @var float */
    protected $gravity = 0.0;
    /** @var float */
    protected $drag = 1.0;

    /** @var Vector3 */
    public $direction = null;

    public $width = 0.5;
    public $height = 0.5;

    public $canCollide = false;

    protected function initEntity(CompoundTag $nbt): void
    {
        $this->setMaxHealth(1);
        $this->setHealth(1);
        parent::initEntity($nbt);
        $this->setEntityProperties(null);
    }

    public function getName(): string
    {
        return "Leash Knot";
    }

    public function attack(EntityDamageEvent $source): void
    {
        if ($source->getCause() === EntityDamageEvent::CAUSE_SUFFOCATION && $this->getLevel()->getBlock($this) instanceof Fence) return;
        parent::attack($source);
    }

    public function onNearbyBlockChange(): void
    {
        parent::onNearbyBlockChange();

        if (!$this->getLevel()->getBlock($this) instanceof Fence) {
            $this->kill();
        }
    }

    public function hasMovementUpdate(): bool
    {
        return false;
    }

    protected function updateMovement(bool $teleport = false): void
    {

    }

    public function canCollideWith(Entity $entity): bool
    {
        return false;
    }

    public function canBeMovedByCurrents(): bool
    {
        return false;
    }

    public function canBeCollidedWith(): bool
    {
        return false;
    }

    public function entityBaseTick(int $tickDiff = 1): bool
    {
        if ($this->ticksLived % 300 === 0 || $this->ticksLived === 0) return parent::entityBaseTick($tickDiff);
        if ($this->getLevel()->getBlock($this) instanceof Fence) {
            return false;
        }
        $this->kill();
        return true;
    }

    public function kill(): void
    {
        $this->getLevel()->broadcastLevelSoundEvent($this, LevelSoundEventPacket::SOUND_LEASHKNOT_BREAK);
        foreach ($this->getLevel()->getEntities() as $entity) {
            if (!$entity instanceof AIEntity) continue;
            if ($entity->getDataPropertyManager()->getLong(self::DATA_LEAD_HOLDER_EID) === $this->getId()) {
                $this->getLevel()->dropItem($entity, new Lead());
                $entity->setLeashedTo(null);
            }
        }
        parent::kill();
    }
}
