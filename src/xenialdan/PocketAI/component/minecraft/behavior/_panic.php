<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _panic extends BaseComponent
{
    protected $name = "minecraft:behavior.panic";
    /** @var bool $force If true, this mob will not stop panicking until it can't move anymore or the goal is removed from it */
    public $force = false;
    /** @var float $speed_multiplier Movement speed multiplier of the mob when using this AI Goal */
    public $speed_multiplier = 1.0;


    /**
     * Allows the mob to enter the panic state and run around in panic.
     * _panic constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->force = $values['force'] ?? $this->force;
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
