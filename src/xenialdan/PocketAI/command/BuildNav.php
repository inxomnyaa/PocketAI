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

namespace xenialdan\PocketAI\command;

use pocketmine\command\CommandSender;
use pocketmine\command\defaults\VanillaCommand;
use pocketmine\lang\TranslationContainer;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use xenialdan\astar3d\Pathfinder;
use xenialdan\PocketAI\entitytype\AIEntity;

class BuildNav extends VanillaCommand
{

    public function __construct($name)
    {
        parent::__construct(
            $name,
            "Build navigation map for all AIEntities",
            "/buildnav"
        );
        $this->setPermission("pocketmine.command.summon");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$this->testPermission($sender) || !$sender instanceof Player) {
            return true;
        }
        /** @var Player $sender */

        foreach ($sender->getLevel()->getEntities() as $entity) {
            if (!$entity instanceof AIEntity) continue;
            $entity->aiManager->pathfinder->StartFindingPath($entity, $sender);
            $entity->aiManager->navigationGrid = $entity->aiManager->pathfinder->grid;
        }
        $sender->sendMessage(TextFormat::RED . "An error occurred");
        return false;
    }
}