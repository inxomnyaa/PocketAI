<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _floats_in_liquid implements BaseComponent
{
    protected $name = "minecraft:floats_in_liquid";
    private $value = true;

    /**
     * Sets that this entity can float in liquid blocks.
     * _floats_in_liquid constructor.
     */
    public function __construct()
    {
    }

    /**
     * Applies the changes to the mob
     * @param AIEntity|AIProjectile $entity
     */
    public
    function apply($entity): void
    {
        // TODO: Implement apply() method.
    }

    /**
     * Removes the changes from the mob
     * @param AIEntity|AIProjectile $entity
     */
    public
    function remove($entity): void
    {
        // TODO: Implement remove() method.
    }
}
