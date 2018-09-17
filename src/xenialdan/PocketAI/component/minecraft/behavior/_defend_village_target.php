<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;
use xenialdan\PocketAI\filter\Filters;

class _defend_village_target extends BaseComponent
{
    protected $name = "minecraft:behavior.defend_village_target";
    /** @var mixed (JSON Object) $entity_types List of entity types this mob considers a threat to the village
     * ;Parameters
     *
     */
    public $entity_types;
    /** @var string (Minecraft Filter) $filters Conditions that make this entry in the list valid */
    public $filters;
    /** @var float $max_dist Maximum distance this mob can be away to be a valid choice */
    public $max_dist = 16;
    /** @var bool $must_see If true, the mob has to be visible to be a valid choice */
    public $must_see = false;
    /** @var float $sprint_speed_multiplier Multiplier for the running speed. A value of 1.0 means the speed is unchanged */
    public $sprint_speed_multiplier = 1.0;
    /** @var float $walk_speed_multiplier Multiplier for the walking speed. A value of 1.0 means the speed is unchanged */
    public $walk_speed_multiplier = 1.0;

    /**
     * Allows the mob to stay in the village and fight mobs hostile to the villagers.
     * _defend_village_target constructor.
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
