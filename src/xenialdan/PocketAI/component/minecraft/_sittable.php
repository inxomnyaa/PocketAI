<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;
use xenialdan\PocketAI\event\CallableEvent;

class _sittable extends BaseComponent
{
    protected $name = "minecraft:sittable";
    /** @var CallableEvent $sit_event Event to run when the entity enters the 'sit' state */
    public $sit_event;
    /** @var CallableEvent $stand_event Event to run when the entity exits the 'sit' state */
    public $stand_event;

    /**
     * Defines the entity's 'sit' state.
     * _sittable constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->sit_event = new CallableEvent($values['sit_event'] ?? []);
        $this->stand_event = new CallableEvent($values['stand_event'] ?? []);

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
