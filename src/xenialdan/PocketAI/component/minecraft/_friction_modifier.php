<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _friction_modifier implements BaseComponent
{
    protected $name = "minecraft:friction_modifier";
    private $value = 1.0;

    /**
     * Defines how much does friction affect this entity.
     * _friction_modifier constructor.
     * @param float $value The higher the number, the more the friction affects this entity. A value of 1.0 means regular friction, while 2.0 means twice as much
     */
    public function __construct(float $value)
    {
        $this->value = $value;
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
