<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _hurt_by_target extends BaseComponent
{
    protected $name = "minecraft:behavior.hurt_by_target";
    /** @var bool $alert_same_type If true, nearby mobs of the same type will be alerted about the damage */
    public $alert_same_type = false;
    /** @var mixed (JSON Object) $entity_types List of entity types that this mob can target when hurt by them
     * ;Parameters
     *
     * : { */
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
            /** @var bool $hurt_owner If true, the mob will hurt its owner and other mobs with the same owner as itself */
            public $hurt_owner = false;
            

    /**
     * Allows the mob to target another mob that hurts them.
     * _hurt_by_target constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->alert_same_type = $values['alert_same_type'] ?? $this->alert_same_type;
        $this->entity_types = $values['entity_types'] ?? $this->entity_types;
        $this->filters = $values['filters'] ?? $this->filters;
        $this->max_dist = $values['max_dist'] ?? $this->max_dist;
        $this->must_see = $values['must_see'] ?? $this->must_see;
        $this->sprint_speed_multiplier = $values['sprint_speed_multiplier'] ?? $this->sprint_speed_multiplier;
        $this->walk_speed_multiplier = $values['walk_speed_multiplier'] ?? $this->walk_speed_multiplier;
        $this->hurt_owner = $values['hurt_owner'] ?? $this->hurt_owner;

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
