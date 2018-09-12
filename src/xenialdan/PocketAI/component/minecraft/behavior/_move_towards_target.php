<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _move_towards_target extends BaseComponent
{
    protected $name = "minecraft:behavior.move_towards_target";
    /** @var float $within_radius Defines the radius in blocks that the mob tries to be from the target. A value of 0 means it tries to occupy the same block as the target */
    public $within_radius = 0.0;


    /**
     * Allows mob to move towards its current target.
     * _move_towards_target constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->within_radius = $values['within_radius'] ?? $this->within_radius;

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
