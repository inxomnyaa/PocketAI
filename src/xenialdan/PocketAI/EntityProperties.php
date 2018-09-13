<?php

namespace xenialdan\PocketAI;

use pocketmine\inventory\InventoryHolder;
use pocketmine\plugin\PluginException;
use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\component\ComponentGroup;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;
use xenialdan\PocketAI\inventory\AIEntityInventory;

class EntityProperties
{
    /** @var \SplQueue|null */
    private $behaviour;
    /** @var string */
    private $behaviourName = "empty";
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

        if (!array_key_exists($behaviour, Loader::$components)) throw new \InvalidArgumentException("Entity behaviour/properties file: " . $behaviour . " not found for entity of type " . $entity->getName());
        $this->behaviour = Loader::$components[$behaviour];
        $this->behaviourName = $behaviour;
        $this->behaviourFile = Loader::$behaviourJson[$behaviour];
        $this->entity = $entity;

        /** @var BaseComponent $component */
        foreach ($this->behaviour as $component){
            $component->apply($this->entity);
        }
    }

    /**
     * @return string
     */
    public function getBehaviourName(): string
    {
        return $this->behaviourName;
    }

    /**
     * @return array
     */
    public function getBehaviours(): array
    {
        return iterator_to_array($this->behaviour);
    }

    public function getBehaviourComponentGroups()
    {
        var_dump("============ BEHAVIOUR COMPONENT GROUPS ============");
        return Loader::$component_groups[$this->getBehaviourName()];
    }

    public function getBehaviourComponentGroup(string $component_group_name) : ?ComponentGroup
    {
        //TODO search for actual name like "minecraft:clock_time"
        return $this->getBehaviourComponentGroups()[$component_group_name] ?? null;
    }

    public function getBehaviourComponents()
    {
        var_dump("============ BEHAVIOUR COMPONENTS ============");
        var_dump(iterator_to_array(Loader::$components[$this->getBehaviourName()]));
        return Loader::$components[$this->getBehaviourName()];
    }

    //TODO use SplQueue?
    public function getBehaviourEvents()
    {
        return Loader::$events[$this->getBehaviourName()];
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
            /** @var BaseComponent $component */
            foreach ($component_group as $component) {
                $component->apply($this->entity);
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