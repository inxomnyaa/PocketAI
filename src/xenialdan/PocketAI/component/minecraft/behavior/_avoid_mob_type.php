<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;
use xenialdan\PocketAI\filter\Filters;

class _avoid_mob_type extends BaseComponent
{
    protected $name = "minecraft:behavior.avoid_mob_type";
    /** @var mixed (JSON Object) $entity_types List of entity types this mob avoids.
     * ;Parameters
     *
     */
    public $entity_types;
    /** @var string (Minecraft Filter) $filters Conditions that make this entry in the list valid */
    public $filters;
    /** @var float $max_dist Maximum distance to look for an entity */
    public $max_dist = 0.0;
    /** @var bool $must_see If true, the mob has to be visible to be a valid choice */
    public $must_see = false;
    /** @var float $sprint_speed_multiplier Multiplier for running speed. 1.0 means keep the regular speed, while higher numbers make the running speed faster */
    public $sprint_speed_multiplier = 1.0;
    /** @var float $walk_speed_multiplier Multiplier for walking speed. 1.0 means keep the regular speed, while higher numbers make the walking speed faster */
    public $walk_speed_multiplier = 1.0;
    /** @var float $probability_per_strength Determines how likely it is that this entity will stop avoiding another entity based on that entity's strength */
    public $probability_per_strength = 1.0;

    /**
     * Allows this entity to avoid certain mob types.
     * _avoid_mob_type constructor.
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
        $this->probability_per_strength = $values['probability_per_strength'] ?? $this->probability_per_strength;

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
