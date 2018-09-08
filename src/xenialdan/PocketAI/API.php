<?php

namespace xenialdan\PocketAI;


use pocketmine\event\entity\EntityDamageByChildEntityEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\level\Level;
use pocketmine\Player;
use xenialdan\PocketAI\entitytype\AIEntity;

class API
{

    public static function checkConditions(AIEntity $entity, array $conditions)
    {
        $target = null;
        foreach ($conditions as $value) {
            switch ($value["condition"]) {
                case "entity_properties":
                    {//function condition
                        switch ($value["entity"]) {
                            case "this":
                                {
                                    $target = $entity;
                                    break;
                                }
                            default:
                                {
                                    Loader::getInstance()->getLogger()->alert("(Yet) Unknown target type: " . $value["entity"]);
                                    return false;
                                }
                        }
                        foreach ($value["properties"] as $property => $propertyValue) {
                            switch ($property) {
                                case "on_fire":
                                    {
                                        if (!$target->isOnFire()) return false;
                                        break;
                                    }
                                default:
                                    {
                                        Loader::getInstance()->getLogger()->alert("(Yet) Unknown entity property: " . $property);
                                        return false;
                                    }
                            }
                        }
                        break;
                    }
                case "killed_by_player":
                    {//roll condition
                        // TODO recode/recheck/recode etc
                        if (($event = $entity->getLastDamageCause()) instanceof EntityDamageEvent and $event instanceof EntityDamageByEntityEvent) {//TODO fix getLastDamageCause on null
                            if (!$event->getDamager() instanceof Player) return false;
                        }
                        break;
                    }
                case "killed_by_entity":
                    {//roll condition
                        // TODO recode/recheck/recode etc
                        if (($event = $entity->getLastDamageCause()) instanceof EntityDamageEvent and $event instanceof EntityDamageByEntityEvent) {//TODO fix getLastDamageCause on null
                            $damager = $event->getDamager();
                            if ($event instanceof EntityDamageByChildEntityEvent) {
                                $damager = $event->getChild()->getOwningEntity();
                            }
                            var_dump("========= SAVE ID OF DAMAGER =========");
                            var_dump($damager->getSaveId());
                            var_dump("========= SEARCHED FOR =========");
                            var_dump($value["entity_type"]);
                            if ($event->getDamager()->getSaveId() !== $value["entity_type"]) return false;
                        }

                        break;
                    }
                case "random_chance_with_looting":
                    {//roll condition
                        var_dump("========= CHANCE =========");
                        var_dump($value["chance"]);
                        var_dump("========= LOOTING_MULTIPLIER =========");
                        var_dump($value["looting_multiplier"]);
                        break;
                    }
                case "random_difficulty_chance":
                    {//loot condition //return nothing yet, those are roll-repeats or so
                        var_dump("========= CHANCE =========");
                        var_dump($value["default_chance"]);
                        var_dump("========= CHANCE FITTING THE DIFFICULTY =========");
                        //TODO
                        foreach ($value as $difficultyString => $chance) {
                            var_dump($difficultyString . " => " . $chance);
                            if ($entity->getLevel()->getDifficulty() === Level::getDifficultyFromString($difficultyString)) {
                                var_dump("========= CHANCE =========");
                                var_dump($chance);
                            }
                        }
                        break;
                    }
                case "random_regional_difficulty_chance":
                    {//roll condition
                        //TODO
                        //no break, send default message
                    }
                default:
                    {
                        Loader::getInstance()->getLogger()->alert("(Yet) Unknown condition: " . $value["condition"]);
                    }
            }

        }
        return true;
    }
}