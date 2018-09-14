<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _rail_movement extends BaseComponent
{
    protected $name = "minecraft:rail_movement";
    /** @var float $max_speed Maximum speed that this entity will move at when on the rail */
    public $max_speed = 0.4;

    /**
     * Defines the entity's movement on the rails. An entity with this component is only allowed to move on the rail.
     * _rail_movement constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->max_speed = $values['max_speed'] ?? $this->max_speed;

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
