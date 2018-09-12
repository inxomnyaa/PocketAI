<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _summon_entity extends BaseComponent
{
    protected $name = "minecraft:behavior.summon_entity";
    /** @var array $summon_choices List of spells for the mob to use to summon entities. Each spell has the following parameters:
     * ;Parameters of each spell
     *
     * : { */
            public $summon_choices;
            /** @var float $cast_duration Time in seconds the spell casting will take */
            public $cast_duration = Total delay of the steps;
            /** @var float $cooldown_time Time in seconds the mob has to wait before using the spell again */
            public $cooldown_time = 0.0;
            /** @var string (Minecraft Filter) $filters */
            public $filters;
            /** @var float $max_activation_range Upper bound of the activation distance in blocks for this spell */
            public $max_activation_range = -1.0;
            /** @var float $min_activation_range Lower bound of the activation distance in blocks for this spell */
            public $min_activation_range = 1.0;
            /** @var int $particle_color The color of the particles for this spell */
            public $particle_color;
            /** @var array $sequence List of steps for the spell. Each step has the following parameters:
             * ;Parameters of each step
             *
             * : { */
            public $sequence;
            /** @var float $base_delay Amount of time in seconds to wait before this step starts */
            public $base_delay = 0.0;
            /** @var float $delay_per_summon Amount of time in seconds before each entity is summoned in this step */
            public $delay_per_summon = 0.0;
            /** @var float $entity_lifespan Amount of time in seconds that the spawned entity will be alive for. A value of -1.0 means it will remain alive for as long as it can */
            public $entity_lifespan = -1.0;
            /** @var string $entity_type The entity type of the entities we will spawn in this step */
            public $entity_type;
            /** @var int $num_entities_spawned Number of entities that will be spawned in this step */
            public $num_entities_spawned = 1;
            /** @var string $shape The base shape of this step. Valid values are circle and line */
            public $shape = "line";
            /** @var float $size The base size of the entity */
            public $size = 1.0;
            /** @var string $sound_event The sound event to play for this step */
            public $sound_event;
            /** @var int $summon_cap Maximum number of summoned entities at any given time */
            public $summon_cap;
            /** @var float $summon_cap_radius */
            public $summon_cap_radius = 0.0;
            /** @var string $target The target of the spell. This is where the spell will start (line will start here, circle will be centered here) */
            public $target = "self";
            /** @var string $start_sound_event The sound event to play when using this spell */
            public $start_sound_event;
            /** @var float $weight The weight of this spell. Controls how likely the mob is to choose this spell when casting one */
            public $weight = 0.0;
            

    /**
     * Allows the mob to attack the player by summoning other entities.
     * _summon_entity constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->summon_choices = $values['summon_choices'] ?? $this->summon_choices;
        $this->cast_duration = $values['cast_duration'] ?? $this->cast_duration;
        $this->cooldown_time = $values['cooldown_time'] ?? $this->cooldown_time;
        $this->filters = $values['filters'] ?? $this->filters;
        $this->max_activation_range = $values['max_activation_range'] ?? $this->max_activation_range;
        $this->min_activation_range = $values['min_activation_range'] ?? $this->min_activation_range;
        $this->particle_color = $values['particle_color'] ?? $this->particle_color;
        $this->sequence = $values['sequence'] ?? $this->sequence;
        $this->base_delay = $values['base_delay'] ?? $this->base_delay;
        $this->delay_per_summon = $values['delay_per_summon'] ?? $this->delay_per_summon;
        $this->entity_lifespan = $values['entity_lifespan'] ?? $this->entity_lifespan;
        $this->entity_type = $values['entity_type'] ?? $this->entity_type;
        $this->num_entities_spawned = $values['num_entities_spawned'] ?? $this->num_entities_spawned;
        $this->shape = $values['shape'] ?? $this->shape;
        $this->size = $values['size'] ?? $this->size;
        $this->sound_event = $values['sound_event'] ?? $this->sound_event;
        $this->summon_cap = $values['summon_cap'] ?? $this->summon_cap;
        $this->summon_cap_radius = $values['summon_cap_radius'] ?? $this->summon_cap_radius;
        $this->target = $values['target'] ?? $this->target;
        $this->start_sound_event = $values['start_sound_event'] ?? $this->start_sound_event;
        $this->weight = $values['weight'] ?? $this->weight;

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
