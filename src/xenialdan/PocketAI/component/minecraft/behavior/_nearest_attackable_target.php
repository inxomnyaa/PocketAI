<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _nearest_attackable_target implements BaseComponent
{
    protected $name = "minecraft:behavior.nearest_attackable_target";
    private $priority;
    private $entity_types;
    private $must_see;

    public function __construct($priority, $entity_types, $must_see)
    {
        $this->priority = $priority;
        $this->entity_types = $entity_types;
        $this->must_see = $must_see;
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
