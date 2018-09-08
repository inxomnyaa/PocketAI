<?php

namespace xenialdan\PocketAI\event;

use pocketmine\event\Cancellable;
use pocketmine\event\plugin\PluginEvent;
use pocketmine\plugin\Plugin;
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
}