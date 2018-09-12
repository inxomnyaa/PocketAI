<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _nearest_attackable_target extends BaseComponent
{
    protected $name = "minecraft:behavior.nearest_attackable_target";
    /** @var int $attack_interval Time in seconds between attacks */
    public $attack_interval;
    /** @var mixed (JSON Object) $entity_types List of entity types that this mob considers valid targets
     * ;Parameters
     *
     * : { */
            public $entity_types;
            /** @var string (Minecraft Filter) $filters Conditions that make this entry in the list valid */
            public $filters;
            /** @var float $max_dist Maximum distance this mob can be away to be a valid choice */
            public $max_dist = 16;
            /** @var bool $must_see If true, only entities in this mob's viewing range can be selected as targets */
            public $must_see = false;
            /** @var float $sprint_speed_multiplier Multiplier for the running speed. A value of 1.0 means the speed is unchanged */
            public $sprint_speed_multiplier = 1.0;
            /** @var float $walk_speed_multiplier Multiplier for the walking speed. A value of 1.0 means the speed is unchanged */
            public $walk_speed_multiplier = 1.0;
            /** @var bool $must_reach If true, only entities that this mob can path to can be selected as targets */
            public $must_reach = false;
            /** @var float $must_see_forget_duration Determines the amount of time in seconds that this mob will look for a target before forgetting about it and looking for a new one when the target isn't visible any more */
            public $must_see_forget_duration = 3.0;
            /** @var bool $reselect_targets If true, the target will change to the current closest entity whenever a different entity is closer */
            public $reselect_targets = false;
            /** @var float $within_radius Distance in blocks that the target can be within to launch an attack */
            public $within_radius = 0.0;
            

    /**
     * Allows the mob to check for and pursue the nearest valid target.
     * _nearest_attackable_target constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->attack_interval = $values['attack_interval'] ?? $this->attack_interval;
        $this->entity_types = $values['entity_types'] ?? $this->entity_types;
        $this->filters = $values['filters'] ?? $this->filters;
        $this->max_dist = $values['max_dist'] ?? $this->max_dist;
        $this->must_see = $values['must_see'] ?? $this->must_see;
        $this->sprint_speed_multiplier = $values['sprint_speed_multiplier'] ?? $this->sprint_speed_multiplier;
        $this->walk_speed_multiplier = $values['walk_speed_multiplier'] ?? $this->walk_speed_multiplier;
        $this->must_reach = $values['must_reach'] ?? $this->must_reach;
        $this->must_see_forget_duration = $values['must_see_forget_duration'] ?? $this->must_see_forget_duration;
        $this->reselect_targets = $values['reselect_targets'] ?? $this->reselect_targets;
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
