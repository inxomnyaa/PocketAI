<?php

namespace xenialdan\PocketAI\event;

use pocketmine\event\Cancellable;
use pocketmine\event\plugin\PluginEvent;
use pocketmine\plugin\Plugin;
use xenialdan\PocketAI\API;
use xenialdan\PocketAI\component\ComponentGroup;
use xenialdan\PocketAI\entitytype\AIEntity;

class AddonEvent extends PluginEvent implements Cancellable
{
    public static $handlerList = null;
    /** @var AIEntity */
    private $entity;
    private $event;

    /**
     * AddonEvent constructor.
     * @param Plugin $plugin
     * @param AIEntity $entity
     * @param string $event
     */
    public function __construct(Plugin $plugin, AIEntity $entity, string $event)
    {
        parent::__construct($plugin);
        $this->setEntity($entity);
        $this->setEvent($event);
        $plugin->getLogger()->info("Called addon event: " . $this->getEvent());
    }

    /**
     * @return AIEntity
     */
    public function getEntity(): AIEntity
    {
        return $this->entity;
    }

    /**
     * @param AIEntity $entity
     */
    public function setEntity(AIEntity $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return string
     */
    public function getEvent(): string
    {
        return $this->event;
    }

    /**
     * @param string $event
     */
    public function setEvent(string $event)
    {
        $this->event = $event;
    }

    /**
     *  Issues an event
     * @param array $data Event data
     */
    public function execute($data): void
    {
        foreach ($data as $function => $function_properties) {
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
                        $subEvents = $function_properties[API::getRandomWeightedElement($array)];
                        $this->execute($subEvents);
                        break;
                    }
                case "add":
                    {
                        foreach ($function_properties as $function_property => $function_property_data) {
                            var_dump($function_property);
                            switch ($function_property) {
                                case "component_groups":
                                    {
                                        foreach ($function_property_data as $group) {
                                            /** @var ComponentGroup|null $componentgroup */
                                            $componentgroup = $this->getEntity()->getEntityProperties()->findComponentGroup($group);
                                            if (!is_null($componentgroup)) $componentgroup->apply($this->entity);
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
                                        foreach ($function_property_data as $group) {
                                            /** @var ComponentGroup|null $componentgroup */
                                            $componentgroup = $this->getEntity()->getEntityProperties()->findComponentGroup($group);
                                            if (!is_null($componentgroup)) $componentgroup->remove($this->entity);
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
}