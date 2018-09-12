<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _share_items extends BaseComponent
{
    protected $name = "minecraft:behavior.share_items";
    /** @var mixed (JSON Object) $entity_types List of entities this mob will share items with
     * ;Parameters
     *
     * : { */
            public $entity_types;
            /** @var string (Minecraft Filter) $filters Conditions that make this entry in the list valid */
            public $filters;
            /** @var float $max_dist Maximum distance in blocks this mob will look for entities to share items with */
            public $max_dist = 0.0;
            /** @var bool $must_see If true, the mob has to be visible to be a valid choice */
            public $must_see = false;
            /** @var float $sprint_speed_multiplier Multiplier for the running speed. A value of 1.0 means the speed is unchanged */
            public $sprint_speed_multiplier = 1.0;
            /** @var float $walk_speed_multiplier Multiplier for the walking speed. A value of 1.0 means the speed is unchanged */
            public $walk_speed_multiplier = 1.0;
            /** @var float $goal_radius Distance in blocks within the mob considers it has reached the goal. This is the "wiggle room" to stop the AI from bouncing back and forth trying to reach a specific spot */
            public $goal_radius = 0.5;
            /** @var float $speed_multiplier Movement speed multiplier of the mob when using this AI Goal */
            public $speed_multiplier = 1.0;
            

    /**
     * Allows the mob to give items it has to others.
     * _share_items constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->entity_types = $values['entity_types'] ?? $this->entity_types;
        $this->filters = $values['filters'] ?? $this->filters;
        $this->max_dist = $values['max_dist'] ?? $this->max_dist;
        $this->must_see = $values['must_see'] ?? $this->must_see;
        $this->sprint_speed_multiplier = $values['sprint_speed_multiplier'] ?? $this->sprint_speed_multiplier;
        $this->walk_speed_multiplier = $values['walk_speed_multiplier'] ?? $this->walk_speed_multiplier;
        $this->goal_radius = $values['goal_radius'] ?? $this->goal_radius;
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
