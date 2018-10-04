<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _pickup_items extends BehaviourComponent
{
    protected $name = "minecraft:behavior.pickup_items";
    /** @var float $goal_radius Distance in blocks within the mob considers it has reached the goal. This is the "wiggle room" to stop the AI from bouncing back and forth trying to reach a specific spot */
    public $goal_radius = 0.5;
    /** @var float $max_dist Maximum distance this mob will look for items to pick up */
    public $max_dist = 0.0;
    /** @var float $speed_multiplier Movement speed multiplier of the mob when using this AI Goal */
    public $speed_multiplier = 1.0;
    /** @var bool $track_target If true, this mob will chase after the target as long as it's a valid target */
    public $track_target = false;

    /**
     * Allows the mob to pick up items on the ground.
     * _pickup_items constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->goal_radius = $values['goal_radius'] ?? $this->goal_radius;
        $this->max_dist = $values['max_dist'] ?? $this->max_dist;
        $this->speed_multiplier = $values['speed_multiplier'] ?? $this->speed_multiplier;
        $this->track_target = $values['track_target'] ?? $this->track_target;

        parent::__construct($values);
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

    public function tick(int $tickDiff)
    {
        // TODO: Implement tick() method.
    }
}
