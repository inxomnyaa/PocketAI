<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _swell implements BaseComponent
{
    protected $name = "minecraft:behavior.swell";
    private $start_distance;
    private $stop_distance;
    private $priority;

    public function __construct($start_distance, $stop_distance, $priority)
    {
        $this->start_distance = $start_distance;
        $this->stop_distance = $stop_distance;
        $this->priority = $priority;
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
