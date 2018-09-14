<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _skeleton_horse_trap extends BaseComponent
{
    protected $name = "minecraft:behavior.skeleton_horse_trap";
    /** @var float $duration Amount of time in seconds the trap exists. After this amount of time is elapsed, the trap is removed from the world if it hasn't been activated */
    public $duration = 1.0;
    /** @var float $within_radius Distance in blocks that the player has to be within to trigger the horse trap */
    public $within_radius = 0.0;

    /**
     * Allows Equine mobs to be Horse Traps and be triggered like them, spawning a lightning bolt and a bunch of horses when a player is nearby. Can only be used by Horses, Mules, Donkeys and Skeleton Horses.
     * _skeleton_horse_trap constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->duration = $values['duration'] ?? $this->duration;
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
