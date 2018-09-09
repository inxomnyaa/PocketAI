<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _ranged_attack implements BaseComponent
{
    protected $name = "minecraft:behavior.ranged_attack";
    private $priority;
    private $speed_multiplier;
    private $attack_interval_min;
    private $attack_interval_max;
    private $attack_radius;

    public function __construct($priority, $speed_multiplier, $attack_interval_min, $attack_interval_max, $attack_radius)
    {
        $this->priority = $priority;
        $this->speed_multiplier = $speed_multiplier;
        $this->attack_interval_min = $attack_interval_min;
        $this->attack_interval_max = $attack_interval_max;
        $this->attack_radius = $attack_radius;
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
