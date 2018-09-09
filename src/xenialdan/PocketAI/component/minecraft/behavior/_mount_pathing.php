<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _mount_pathing implements BaseComponent
{
    protected $name = "minecraft:behavior.mount_pathing";
    private $priority;
    private $speed_multiplier;
    private $target_dist;
    private $track_target;

    public function __construct($priority, $speed_multiplier, $target_dist, $track_target)
    {
        $this->priority = $priority;
        $this->speed_multiplier = $speed_multiplier;
        $this->target_dist = $target_dist;
        $this->track_target = $track_target;
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
