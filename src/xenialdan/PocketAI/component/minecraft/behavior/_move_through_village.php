<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _move_through_village extends BaseComponent
{
    protected $name = "minecraft:behavior.move_through_village";
    /** @var bool $only_at_night If true, the mob will only move through the village during night time */
    public $only_at_night = false;
    /** @var float $speed_multiplier Movement speed multiplier of the mob when using this AI Goal */
    public $speed_multiplier = 1.0;


    /**
     * Allows mob to path through villages.
     * _move_through_village constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->only_at_night = $values['only_at_night'] ?? $this->only_at_night;
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
