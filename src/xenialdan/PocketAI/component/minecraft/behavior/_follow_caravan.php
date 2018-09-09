<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _follow_caravan implements BaseComponent
{
    protected $name = "minecraft:behavior.follow_caravan";
    private $priority;
    private $speed_multiplier;
    private $entity_count;
    private $entity_types;

    public function __construct($priority, $speed_multiplier, $entity_count, $entity_types)
    {
        $this->priority = $priority;
        $this->speed_multiplier = $speed_multiplier;
        $this->entity_count = $entity_count;
        $this->entity_types = $entity_types;
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
