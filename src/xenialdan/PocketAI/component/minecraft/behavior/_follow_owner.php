<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _follow_owner extends BehaviourComponent
{
    protected $name = "minecraft:behavior.follow_owner";
    /** @var float $speed_multiplier Movement speed multiplier of the mob when using this AI Goal */
    public $speed_multiplier = 1.0;
    /** @var float $start_distance The distance in blocks that the owner can be away from this mob before it starts following it */
    public $start_distance = 10.0;
    /** @var float $stop_distance The distance in blocks this mob will stop from its owner while following it */
    public $stop_distance = 2.0;

    /**
     * Allows the mob to follow the player that owns them.
     * _follow_owner constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->speed_multiplier = $values['speed_multiplier'] ?? $this->speed_multiplier;
        $this->start_distance = $values['start_distance'] ?? $this->start_distance;
        $this->stop_distance = $values['stop_distance'] ?? $this->stop_distance;

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
