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

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use xenialdan\PocketAI\EntityProperties;
use xenialdan\PocketAI\entitytype\AIEntity;

class Guardian extends AIEntity
{
    const NETWORK_ID = self::GUARDIAN;

    /** @var Vector3 */
    public $direction = null;
    public $speed = 0.1 * 5;//TODO dynamic
    public $landSpeed = 0.1 * 2;

    private $switchDirectionTicker = 0;

    protected function initEntity(CompoundTag $nbt): void
    {
        $this->setEntityProperties(new EntityProperties("entities/guardian", $this));
        $this->setBreathing(false);
        parent::initEntity($nbt);
        //$this->addEffect(Effect::getEffect(Effect::WATER_BREATHING)->setDuration(INT32_MAX)->setVisible(false)); // Fixes death in water
    }

    public function getName(): string
    {
        return "Guardian";
    }

    public function attack(EntityDamageEvent $source): void
    {
        parent::attack($source);
        if ($source->isCancelled()) {
            return;
        }

        if ($source instanceof EntityDamageByEntityEvent) {
            $this->speed = mt_rand(150 * 5, 350 * 5) / 2000;
            $e = $source->getDamager();
            if ($e !== null) {
                $this->direction = (new Vector3($this->x - $e->x, $this->y - $e->y, $this->z - $e->z))->normalize();
            }
        }
    }

    public function entityBaseTick(int $tickDiff = 1): bool
    {
        if ($this->closed !== false) {
            return false;
        }

        if (++$this->switchDirectionTicker >= 100 or $this->isCollided || $this->onGround) {
            $this->switchDirectionTicker = 0;
            if (mt_rand(0, 50) < 10) {
                $this->direction = $this->generateRandomDirection();
            }
        }

        $hasUpdate = parent::entityBaseTick($tickDiff);

        if ($this->isAlive()) {

            $inWater = $this->isUnderwater();
            if ($this->y > 62 and $this->direction !== null && $inWater) {
                $this->direction->y = -0.5;
            }
            if (!$inWater) {
                if ($this->onGround) {
                    $this->switchDirectionTicker = 100;
                }
                $this->jump();
                if ($this->direction !== null) {
                    if ($this->motion->x ** 2 + $this->motion->y ** 2 + $this->motion->z ** 2 <= $this->direction->lengthSquared()) {
                        $this->motion->x = $this->direction->x * $this->landSpeed;
                        $this->motion->z = $this->direction->z * $this->landSpeed;
                    }
                }
            } elseif ($this->direction !== null && $this->switchDirectionTicker < 50) {
                if ($this->motion->x ** 2 + $this->motion->y ** 2 + $this->motion->z ** 2 <= $this->direction->lengthSquared()) {
                    $this->motion->x = $this->direction->x * $this->speed;
                    $this->motion->y = $this->direction->y * $this->speed;
                    $this->motion->z = $this->direction->z * $this->speed;
                }
            } else {
                $this->speed = mt_rand(50 * 5, 100 * 5) / 2000;
                $this->direction = null;
            }

            #$f = sqrt(($this->motion->x ** 2) + ($this->motion->z ** 2));
            $this->yaw = (-atan2($this->motion->x, $this->motion->z) * 180 / M_PI);
            #$this->pitch = (-atan2($f, $this->motion->y) * 180 / M_PI);
        }

        return $hasUpdate;
    }

    protected function applyGravity(): void
    {
        if ($this->isInAir()) {
            parent::applyGravity();
        }
    }
}
