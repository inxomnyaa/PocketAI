<?php

namespace xenialdan\PocketAI;


use pocketmine\event\entity\EntityDamageByChildEntityEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\plugin\PluginException;
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

    /**
     * https://stackoverflow.com/a/11872928/4532380
     * getRandomWeightedElement()
     * Utility function for getting random values with weighting.
     * Pass in an associative array, such as array('A'=>5, 'B'=>45, 'C'=>50)
     * An array like this means that "A" has a 5% chance of being selected, "B" 45%, and "C" 50%.
     * The return value is the array key, A, B, or C in this case.  Note that the values assigned
     * do not have to be percentages.  The values are simply relative to each other.  If one value
     * weight was 2, and the other weight of 1, the value with the weight of 2 has about a 66%
     * chance of being selected.  Also note that weights should be integers.
     *
     * @param int[] $weightedValues
     * @return mixed $key
     */
    public static function getRandomWeightedElement(array $weightedValues)
    {
        if (empty($weightedValues)) {
            throw new PluginException("The weighted values are empty");
        }
        $rand = mt_rand(1, (int)array_sum($weightedValues));

        foreach ($weightedValues as $key => $value) {
            $rand -= $value;
            if ($rand <= 0) {
                return $key;
            }
        }
        return -1;
    }
}