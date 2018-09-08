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
use pocketmine\entity\Living;
use pocketmine\entity\projectile\Projectile;
use pocketmine\Player;

class KillentityCommand extends VanillaCommand
{

    public function __construct($name)
    {
        parent::__construct(
            $name,
            "Kill entities",
            "/killentity"
        );
        $this->setPermission("pocketmine.command.killentity");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$this->testPermission($sender)) {
            return true;
        }

        /*if (count($args) != 1 and count($args) != 4 and count($args) != 5){
            $sender->sendMessage(new TranslationContainer("commands.generic.usage", [$this->usageMessage]));
            return true;
        }*/

        if ($sender instanceof Player) {
            foreach ($sender->getLevel()->getEntities() as $entity) {
                if (($entity instanceof Living || $entity instanceof Projectile) && !$entity instanceof Player) {
                    $entity->close();
                }
            }
        } else {
            foreach ($sender->getServer()->getLevels() as $level) {
                foreach ($level->getEntities() as $entity) {
                    if ($entity instanceof Living && !$entity instanceof Player) {
                        $entity->close();
                    }
                }

            }
        }
        return true;
    }
}