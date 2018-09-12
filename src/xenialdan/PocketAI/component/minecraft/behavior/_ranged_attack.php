<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _ranged_attack extends BaseComponent
{
    protected $name = "minecraft:behavior.ranged_attack";
    /** @var int $attack_interval_max Maximum amount of time in seconds the entity will wait after an attack before launching another */
    public $attack_interval_max;
    /** @var int $attack_interval_min Minimum amount of time in seconds the entity will wait after an attack before launching another */
    public $attack_interval_min;
    /** @var float $attack_radius Maxmimum distance the target can be for this mob to fire. If the target is further away, this mob will move first before firing */
    public $attack_radius = 0.0;
    /** @var float $burst_interval Amount of time in seconds between each individual shot when firing multiple shots per attack */
    public $burst_interval = 0.0;
    /** @var int $burst_shots Number of shots fired every time the mob uses a charged attack */
    public $burst_shots = 1;
    /** @var float $charge_charged_trigger The minimum amount of time in ticks the mob has to charge before firing a charged attack */
    public $charge_charged_trigger = 0.0;
    /** @var float $charge_shoot_trigger The minimum amount of time in ticks for the mob to start charging a charged shot. Must be greater than 0 to enable burst shots */
    public $charge_shoot_trigger = 0.0;
    /** @var float $speed_multiplier Movement speed multiplier of the mob when using this AI Goal */
    public $speed_multiplier = 1.0;


    /**
     * Allows the mob to use ranged attacks like shooting arrows.
     * _ranged_attack constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->attack_interval_max = $values['attack_interval_max'] ?? $this->attack_interval_max;
        $this->attack_interval_min = $values['attack_interval_min'] ?? $this->attack_interval_min;
        $this->attack_radius = $values['attack_radius'] ?? $this->attack_radius;
        $this->burst_interval = $values['burst_interval'] ?? $this->burst_interval;
        $this->burst_shots = $values['burst_shots'] ?? $this->burst_shots;
        $this->charge_charged_trigger = $values['charge_charged_trigger'] ?? $this->charge_charged_trigger;
        $this->charge_shoot_trigger = $values['charge_shoot_trigger'] ?? $this->charge_shoot_trigger;
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
