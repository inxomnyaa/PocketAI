<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _collision_box implements BaseComponent
{
    protected $name = "minecraft:collision_box";
    private $width = 1.0;
    private $height = 1.0;

    /**
     * Sets the width and height of the Entity's collision box.
     * _collision_box constructor.
     * @param float $width Height of the Collision Box in Blocks
     * @param float $height Width and Depth of the Collision Box in Blocks
     */
    public function __construct(float $width, float $height)
    {
        $this->width = $width;
        $this->height = $height;
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
