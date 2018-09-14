<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _melee_attack extends BaseComponent
{
    protected $name = "minecraft:behavior.melee_attack";
    /** @var string $attack_types Defines the entity types this mob will attack */
    public $attack_types;
    /** @var int $random_stop_interval Defines the probability the mob will stop fighting. A value of 0 disables randomly stopping, while a value of 1 defines a 50% chance */
    public $random_stop_interval;
    /** @var float $reach_multiplier Multiplier for how far outside its box the mob can reach its target (this can be used to simulate a mob with longer arms by making this bigger) */
    public $reach_multiplier = 2.0;
    /** @var float $speed_multiplier Movement speed multiplier of the mob when using this AI Goal */
    public $speed_multiplier = 1.0;
    /** @var bool $track_target If true, this mob will chase after the target as long as it's a valid target */
    public $track_target = false;

    /**
     * Allows the mob to use close combat melee attacks.
     * _melee_attack constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->attack_types = $values['attack_types'] ?? $this->attack_types;
        $this->random_stop_interval = $values['random_stop_interval'] ?? $this->random_stop_interval;
        $this->reach_multiplier = $values['reach_multiplier'] ?? $this->reach_multiplier;
        $this->speed_multiplier = $values['speed_multiplier'] ?? $this->speed_multiplier;
        $this->track_target = $values['track_target'] ?? $this->track_target;

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
