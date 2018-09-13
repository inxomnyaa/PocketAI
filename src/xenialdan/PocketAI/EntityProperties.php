<?php

namespace xenialdan\PocketAI;

use pocketmine\inventory\InventoryHolder;
use pocketmine\plugin\PluginException;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;
use xenialdan\PocketAI\inventory\AIEntityInventory;

class EntityProperties
{
    private $behaviour = "empty";
    /** @var null|AIEntity|AIProjectile|InventoryHolder */
    private $entity;
    private $behaviourFile = [];
    /** @var array */
    public $componentGroups = [];
    /** @var array */
    public $components = [];

    /**
     * EntityProperties constructor.
     * @param string $behaviour
     * @param AIEntity|AIProjectile $entity
     */
    public function __construct(string $behaviour, $entity)
    {
        if (is_null($entity)){
            throw new PluginException("Can not initialize EntityProperties because no / an invalid null entity was given");
        }
        if (!$entity instanceof AIEntity && !$entity instanceof AIProjectile) {
            throw new PluginException("Can not initialize EntityProperties for class of type: " . get_class($entity));
        }

        if (!array_key_exists($behaviour, Loader::$behaviours)) throw new \InvalidArgumentException("Entity behaviour/properties file: " . $behaviour . " not found for entity of type " . $entity->getName());
        $this->behaviour = Loader::$behaviours[$behaviour];
        $this->behaviourFile = Loader::$behaviourJson[$behaviour];
        $this->entity = $entity;
    }

    /**
     * @return array
     */
    public function getBehaviours(): array
    {
        return $this->behaviourFile;
    }

    public function getBehaviourComponentGroups()
    {
        return $this->behaviourFile["minecraft:entity"]["component_groups"];
    }

    public function getBehaviourComponentGroup(string $component_group_name)
    {
        return $this->getBehaviourComponentGroups()[$component_group_name] ?? null;
    }

    public function getBehaviourComponents()
    {
        var_dump("============ BEHAVIOUR COMPONENTS ============");
        var_dump(array_keys($this->behaviourFile["minecraft:entity"]["components"]));
        return $this->behaviourFile["minecraft:entity"]["components"];
    }

    //TODO use SplQueue?
    public function getBehaviourEvents()
    {
        return $this->behaviourFile["minecraft:entity"]["events"];
    }

    public function getActiveComponentGroups()
    {
        var_dump("============ ACTIVE GROUPS ============");
        var_dump(array_keys($this->componentGroups));
        return $this->componentGroups;
    }

    public function addActiveComponentGroup(string $component_group_name)
    {
        var_dump("============ ADD GROUP NAME ============");
        var_dump($component_group_name);
        if (!is_null(($component_group = $this->getBehaviourComponentGroup($component_group_name)))) {
            $this->componentGroups[$component_group_name] = $component_group;
            var_dump("============ ADDED COMPONENT GROUP ============");
            var_dump($component_group_name);
            foreach ($component_group as $component_name => $component_data) {
                $this->applyComponent($component_name, $component_data);
            }
        }
        $this->getActiveComponentGroups();//TODO remove, only var dumps debug
    }

    public function removeActiveComponentGroup(string $component_group_name)
    {
        var_dump("============ REMOVE GROUP NAME ============");
        var_dump($component_group_name);
        if (!is_null(($component_group = $this->getBehaviourComponentGroup($component_group_name)))) {
            $this->componentGroups[$component_group_name] = $component_group;
            var_dump("============ REMOVED COMPONENT GROUP ============");
            var_dump($component_group_name);
            #foreach ($component_group as $component_name => $component_data){
            #	$this->applyComponent($component_name, $component_data);
            #}
            //TODO set the groups properties
            unset($this->componentGroups[$component_group_name]);
        }
        $this->getActiveComponentGroups();
    }

    /**
     * @return array
     */
    public function getComponents(): array
    {
        return $this->components;
    }

    /**
     * @param array $components
     */
    public function setComponents(array $components)
    {
        $this->components = $components;
    }

    /**
     * @param string $component
     * @param $value
     */
    public function setComponent(string $component, $value)
    {
        $this->components[$component] = $value;
    }

    public function hasComponent(string $component)
    {
        return array_key_exists($component, $this->getComponents());
    }

    public function getComponent(string $component)
    {
        if ($this->hasComponent($component)) return $this->getComponents()[$component];
        return [];
    }

    /* "API"-alike part */

    public function applyComponent(string $component_name, array $component_data)
    {//TODO add reversing removeComponent function
        var_dump("============ APPLY COMPONENT ============");
        var_dump($component_name);
        $this->setComponent($component_name, $component_data);
        switch ($component_name) {
            case "minecraft:loot":
                {
                    var_dump("============ SET LOOT TABLE ============");
                    if (isset($component_data["table"])) $this->entity->setLootGenerator(new LootGenerator($component_data["table"], $this->entity));
                    var_dump($component_data["table"]);
                    break;
                }
            case "minecraft:collision_box":
                {
                    var_dump("============ SET AABB ============");
                    $this->entity->setWidth(floatval($component_data["width"]));
                    $this->entity->setHeight(floatval($component_data["height"]));
                    var_dump($this->entity->getBoundingBox());
                    break;
                }
            case "minecraft:scale":
                {
                    var_dump("============ SET SCALE ============");
                    $this->entity->setScale(floatval($component_data["value"]));
                    var_dump($this->entity->getScale());
                    break;
                }
            case "minecraft:is_baby":
                {
                    var_dump("============ SET BABY ============");
                    $this->entity->setGenericFlag(AIEntity::DATA_FLAG_BABY, true);//TODO set false on removal
                    break;
                }
            case "minecraft:is_tamed":
                {
                    var_dump("============ SET IS_TAMED ============");//TODO set false on removal
                    $this->entity->setGenericFlag(AIEntity::DATA_FLAG_TAMED, true);
                    break;
                }
            case "minecraft:can_climb":
                {
                    var_dump("============ SET CAN CLIMB ============");
                    $this->entity->setCanClimb(true);
                    break;
                }
            case "minecraft:breathable":
                {//TODO add other breathable tags -> see documentation
                    var_dump("============ SET BREATHABLE ============");
                    if (isset($component_data["totalSupply"])) $this->entity->setMaxAirSupplyTicks(intval($component_data["totalSupply"]));
                    if (isset($component_data["breathesWater"]) && $component_data["breathesWater"] == true) {
                        $this->entity->setMaxAirSupplyTicks(10000);//todo
                    }
                    var_dump($this->entity->getMaxAirSupplyTicks());
                    break;
                }
            case "minecraft:health":
                {
                    var_dump("============ SET HEALTH ============");
                    if (isset($component_data["max"])) $this->entity->setMaxHealth(intval($component_data["max"]));
                    if (isset($component_data["value"]) && $this->entity->ticksLived < 1) {
                        if (is_array($component_data["value"])) {
                            $this->entity->setHealth(floatval(mt_rand(($component_data["value"]["range_min"] ?? 1) * 10, ($component_data["value"]["range_max"] ?? 1) * 10) / 10));
                        } else {
                            $this->entity->setHealth(floatval($component_data["value"]));
                        }
                    }
                    var_dump($this->entity->getHealth());
                    break;
                }
            case "minecraft:horse.jump_strength":
                {
                    var_dump("============ SET HORSE JUMP STRENGTH ============");
                    if (isset($component_data["max"])) $this->entity->getAttributeMap()->getAttribute(Loader::HORSE_JUMP_POWER)->setMaxValue(floatval($component_data["max"]));
                    if (isset($component_data["value"]) && $this->entity->ticksLived < 1) {
                        if (is_array($component_data["value"])) {
                            $this->entity->getAttributeMap()->getAttribute(Loader::HORSE_JUMP_POWER)->setValue(floatval(mt_rand(($component_data["value"]["range_min"] ?? 1) * 10, ($component_data["value"]["range_max"] ?? 1) * 10) / 10));
                        } else {
                            $this->entity->getAttributeMap()->getAttribute(Loader::HORSE_JUMP_POWER)->setValue(floatval($component_data["value"]));
                        }
                    }
                    var_dump($this->entity->getAttributeMap()->getAttribute(Loader::HORSE_JUMP_POWER)->getValue());
                    break;
                }
            case "minecraft:movement":
                {
                    var_dump("============ SET MOVEMENT - AKA SPEED ============");
                    if (isset($component_data["value"]) && $this->entity->ticksLived < 1) {
                        if (is_array($component_data["value"])) {
                            $this->entity->setDefaultSpeed(floatval(mt_rand(($component_data["value"]["range_min"] ?? 1) * 10, ($component_data["value"]["range_max"] ?? 1) * 10) / 10));
                        } else {
                            $this->entity->setDefaultSpeed(floatval($component_data["value"]));
                        }
                    }
                    var_dump($this->entity->getDefaultSpeed());
                    break;
                }
            case "minecraft:attack":
                {
                    if ($this->entity->ticksLived < 1) {
                        var_dump("============ SET ATTACK ============");
                        $this->entity->setDefaultAttackDamage(intval($component_data["damage"]));
                    }
                    var_dump($this->entity->getDefaultAttackDamage());
                    break;
                }
            case "minecraft:rideable":
                {
                    var_dump("============ SET RIDEABLE ============");
                    if (isset($component_data["seat_count"])) $this->entity->setSeatCount(intval($component_data["seat_count"]));
                    if (isset($component_data["seats"])) $this->entity->setSeats([$component_data["seats"]]); //TODO validate seatcount === count of "seats"
                    var_dump($this->entity->getSeatCount());
                    var_dump($this->entity->getSeats());
                    break;
                }
            case "minecraft:inventory":
                {
                    var_dump("============ SET INVENTORY ============");
                    var_dump($component_data);
                    if (isset($component_data["container_type"])) {
                        try {
                            $this->entity->setInventory(new AIEntityInventory($this->entity, [], null, null, $component_data["container_type"]));
                        } catch (\Exception $e) {
                        }
                    }
                    var_dump($this->entity->getInventory()->getName());
                    break;
                }
            default:
                {
                    var_dump("============ TRIED TO APPLY UNIMPLEMENTED COMPONENT ============");
                    var_dump($component_name);
                }
        }
    }

    public function applyEvent($behaviourEvent_data)
    {
        var_dump("============ EVENT DATA ============");
        var_dump($behaviourEvent_data);
        foreach ($behaviourEvent_data as $function => $function_properties) {
            var_dump("============ EVENT ============");
            var_dump($function);
            switch ($function) {
                case "randomize":
                    {
                        $array = [];
                        foreach ($function_properties as $index => $property) {
                            $array[] = $property["weight"] ?? 1;
                        }
                        //TODO temp fix, remove when fixed
                        $subEvents = $function_properties[$this->getRandomWeightedElement($array)];
                        $this->applyEvent($subEvents);
                        break;
                    }
                case "add":
                    {
                        foreach ($function_properties as $function_property => $function_property_data) {
                            var_dump($function_property);
                            switch ($function_property) {
                                case "component_groups":
                                    {
                                        foreach ($function_property_data as $componentgroup) {
                                            $this->addActiveComponentGroup($componentgroup);
                                        }
                                        break;
                                    }
                                default:
                                    {
                                        $this->entity->getLevel()->getServer()->getLogger()->notice("Function \"" . $function_property . "\" for add component events is not coded into the plugin yet");
                                    }
                            }
                        }
                        break;
                    }
                case "remove":
                    {
                        foreach ($function_properties as $function_property => $function_property_data) {
                            var_dump($function_property);
                            switch ($function_property) {
                                case "component_groups":
                                    {
                                        foreach ($function_property_data as $componentgroup) {
                                            $this->removeActiveComponentGroup($componentgroup);
                                        }
                                        break;
                                    }
                                default:
                                    {
                                        $this->entity->getLevel()->getServer()->getLogger()->notice("Function \"" . $function_property . "\" for remove component events is not coded into the plugin yet");
                                    }
                            }
                        }
                        break;
                    }
                case "weight":
                    {
                        //just a property, ignore it
                        break;
                    }
                default:
                    {
                        $this->entity->getLevel()->getServer()->getLogger()->notice("Function \"" . $function . "\" for behaviour events is not coded into the plugin yet");
                    }
            }
        }
    }

    /* HELPER FUNCTIONS */
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
            throw new PluginException("Config error! No sets exist in the config - don't you want to give the players anything?");
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