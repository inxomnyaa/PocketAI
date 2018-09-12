<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _run_around_like_crazy extends BaseComponent
{
    protected $name = "minecraft:behavior.run_around_like_crazy";
    /** @var float $speed_multiplier Movement speed multiplier of the mob when using this AI Goal */
    public $speed_multiplier = 1.0;


    /**
     * Allows the mob to run around aimlessly.
     * _run_around_like_crazy constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->speed_multiplier = $values['speed_multiplier'] ?? $this->speed_multiplier;

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
