<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _raid_garden extends BaseComponent
{
    protected $name = "minecraft:behavior.raid_garden";
    /** @var array $blocks Blocks that the mob is looking for to eat */
    public $blocks;
    /** @var int $eat_delay Time in seconds between each time it eats */
    public $eat_delay = 2;
    /** @var int $full_delay Amount of time in seconds before this mob wants to eat again */
    public $full_delay = 100;
    /** @var float $goal_radius Distance in blocks within the mob considers it has reached the goal. This is the "wiggle room" to stop the AI from bouncing back and forth trying to reach a specific spot */
    public $goal_radius = 0.5;
    /** @var int $max_to_eat Maximum number of things this entity wants to eat */
    public $max_to_eat = 6;
    /** @var int $search_range Distance in blocks the mob will look for crops to eat */
    public $search_range;
    /** @var float $speed_multiplier Movement speed multiplier of the mob when using this AI Goal */
    public $speed_multiplier = 1.0;


    /**
     * Allows the mob to eat crops out of farms until they are full.
     * _raid_garden constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->blocks = $values['blocks'] ?? $this->blocks;
        $this->eat_delay = $values['eat_delay'] ?? $this->eat_delay;
        $this->full_delay = $values['full_delay'] ?? $this->full_delay;
        $this->goal_radius = $values['goal_radius'] ?? $this->goal_radius;
        $this->max_to_eat = $values['max_to_eat'] ?? $this->max_to_eat;
        $this->search_range = $values['search_range'] ?? $this->search_range;
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
