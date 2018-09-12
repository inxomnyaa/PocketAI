<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _sittable extends BaseComponent
{
    protected $name = "minecraft:sittable";
    /** @var string $sit_event Event to run when the entity enters the 'sit' state */
    public $sit_event;
    /** @var string $stand_event Event to run when the entity exits the 'sit' state */
    public $stand_event;


    /**
     * Defines the entity's 'sit' state.
     * _sittable constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->sit_event = $values['sit_event'] ?? $this->sit_event;
        $this->stand_event = $values['stand_event'] ?? $this->stand_event;

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
