<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _follow_mob extends BaseComponent
{
    protected $name = "minecraft:behavior.follow_mob";
    /** @var int $search_range The distance in blocks it will look for a mob to follow */
    public $search_range;
    /** @var float $speed_multiplier Movement speed multiplier of the mob when using this AI Goal */
    public $speed_multiplier = 1.0;
    /** @var float $stop_distance The distance in blocks this mob stops from the mob it is following */
    public $stop_distance = 2.0;


    /**
     * Allows the mob to follow other mobs.
     * _follow_mob constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->search_range = $values['search_range'] ?? $this->search_range;
        $this->speed_multiplier = $values['speed_multiplier'] ?? $this->speed_multiplier;
        $this->stop_distance = $values['stop_distance'] ?? $this->stop_distance;

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
