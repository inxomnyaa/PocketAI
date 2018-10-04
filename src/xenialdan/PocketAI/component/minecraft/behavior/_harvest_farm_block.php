<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _harvest_farm_block extends BehaviourComponent
{
    protected $name = "minecraft:behavior.harvest_farm_block";
    /** @var float $speed_multiplier Movement speed multiplier of the mob when using this AI Goal */
    public $speed_multiplier = 1.0;

    /**
     * Allows the villager to harvest nearby farms. Can only be used by Villagers.
     * _harvest_farm_block constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->speed_multiplier = $values['speed_multiplier'] ?? $this->speed_multiplier;

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
