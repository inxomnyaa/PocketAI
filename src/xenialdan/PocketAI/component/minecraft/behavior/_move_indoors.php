<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _move_indoors extends BaseComponent
{
    protected $name = "minecraft:behavior.move_indoors";
    /** @var float $speed_multiplier Movement speed multiplier of the mob when using this AI Goal */
    public $speed_multiplier = 1.0;


    /**
     * Can only be used by Villagers. Allows them to seek shelter indoors.
     * _move_indoors constructor.
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
