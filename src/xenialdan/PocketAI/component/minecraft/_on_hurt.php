<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\component\IEvent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _on_hurt extends BaseComponent implements IEvent
{
    protected $name = "minecraft:on_hurt";
    /** @var string $event The event to run when the conditions for this trigger are met */
    public $event;
    /** @var string (Minecraft Filter) $filters The list of conditions for this trigger */
    public $filters;
    /** @var string $target The target of the event */
    public $target = "self";

    /**
     * Adds a trigger to call when this entity takes damage.
     * _on_hurt constructor.
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
