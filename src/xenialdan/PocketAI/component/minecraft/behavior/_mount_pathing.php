<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _mount_pathing extends BaseComponent
{
    protected $name = "minecraft:behavior.mount_pathing";
    /** @var float $speed_multiplier Movement speed multiplier of the mob when using this AI Goal */
    public $speed_multiplier = 1.0;
    /** @var float $target_dist The distance at which this mob wants to be away from its target */
    public $target_dist = 0.0;
    /** @var bool $track_target If true, this mob will chase after the target as long as it's a valid target */
    public $track_target = false;


    /**
     * Allows the mob to move around on its own while mounted seeking a target to attack.
     * _mount_pathing constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->speed_multiplier = $values['speed_multiplier'] ?? $this->speed_multiplier;
        $this->target_dist = $values['target_dist'] ?? $this->target_dist;
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
