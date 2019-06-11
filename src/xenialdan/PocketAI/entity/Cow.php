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

use pocketmine\math\Vector3;
use xenialdan\PocketAI\ai\AIManager;
use xenialdan\PocketAI\EntityProperties;
use xenialdan\PocketAI\entitytype\AIEntity;

class Cow extends AIEntity
{
    const NETWORK_ID = self::COW;

    /** @var Vector3 */
    public $direction = null;

    protected function initEntity(/*CompoundTag $nbt*/): void
    {
        parent::initEntity(/*$nbt*/);
        $this->setEntityProperties(new EntityProperties("entities/cow", $this));
        $this->aiManager = new AIManager($this);
    }

    public function getName(): string
    {
        return "Cow";
    }
}
