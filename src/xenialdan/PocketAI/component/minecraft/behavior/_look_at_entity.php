<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _look_at_entity implements BaseComponent
{
    protected $name = "minecraft:behavior.look_at_entity";
    private $priority;
    private $look_distance;
    private $probability;
    private $filters;

    public function __construct($priority, $look_distance, $probability, $filters)
    {
        $this->priority = $priority;
        $this->look_distance = $look_distance;
        $this->probability = $probability;
        $this->filters = $filters;
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
