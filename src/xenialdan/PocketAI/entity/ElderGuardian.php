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
use xenialdan\PocketAI\EntityProperties;
use xenialdan\PocketAI\entitytype\AIEntity;

class ElderGuardian extends Guardian
{
    const NETWORK_ID = self::ELDER_GUARDIAN;

    /** @var Vector3 */
    public $direction = null;

    protected function initEntity(/*CompoundTag $nbt*/): void
    {
        $this->setEntityProperties(new EntityProperties("entities/elder_guardian", $this));
        AIEntity::initEntity(/*$nbt*/);

        //$this->addEffect(Effect::getEffect(Effect::WATER_BREATHING)->setDuration(INT32_MAX)->setVisible(false)); // Fixes death in water
        $this->setDataFlag(self::DATA_FLAGS, self::DATA_FLAG_ELDER, true, self::DATA_TYPE_BYTE);
    }

    public function getName(): string
    {
        return "Elder Guardian";
    }

    public function attack(EntityDamageEvent $source): void
    {
        parent::attack($source);
        if ($source->isCancelled()) {
            return;
        }

        if ($source instanceof EntityDamageByEntityEvent) {
            $this->speed = mt_rand(50 * 5, 100 * 5) / 2000;
            $e = $source->getDamager();
            if ($e !== null) {
                $this->direction = (new Vector3($this->x - $e->x, $this->y - $e->y, $this->z - $e->z))->normalize();
            }
        }
    }
}
