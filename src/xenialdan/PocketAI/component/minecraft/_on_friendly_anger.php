<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _on_friendly_anger extends BaseComponent
{
    protected $name = "minecraft:on_friendly_anger";
    /** @var string $event The event to run when the conditions for this trigger are met */
    public $event;
    /** @var string (Minecraft Filter) $filters The list of conditions for this trigger */
    public $filters;
    /** @var string $target The target of the event */
    public $target = "self";

    /**
     * Adds a trigger that will run when a nearby entity of the same type as this entity becomes Angry.
     * _on_friendly_anger constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->event = $values['event'] ?? $this->event;
        $this->filters = $values['filters'] ?? $this->filters;
        $this->target = $values['target'] ?? $this->target;

    }

    /**
     * Applies the changes to the mob
     * @param AIEntity|AIProjectile $entity
     */
    public function apply($entity): void
    {
        // TODO: Implement apply() method.
    }

    /**
     * Removes the changes from the mob
     * @param AIEntity|AIProjectile $entity
     */
    public function remove($entity): void
    {
        // TODO: Implement remove() method.
    }
}
