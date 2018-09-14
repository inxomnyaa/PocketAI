<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _collision_box extends BaseComponent
{
    protected $name = "minecraft:collision_box";
    /** @var float $height Height of the Collision Box in Blocks */
    public $height = 1.0;
    /** @var float $width Width and Depth of the Collision Box in Blocks */
    public $width = 1.0;

    /**
     * Sets the width and height of the Entity's collision box.
     * _collision_box constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->height = $values['height'] ?? $this->height;
        $this->width = $values['width'] ?? $this->width;

    }

    /**
     * Applies the changes to the mob
     * @param AIEntity|AIProjectile $entity
     */
    public function apply($entity): void
    {
        $entity->setWidth($this->width);
        $entity->setHeight($this->height);
    }

    /**
     * Removes the changes from the mob
     * @param AIEntity|AIProjectile $entity
     */
    public function remove($entity): void
    {
        $c = new self;
        $entity->setWidth($c->width);
        $entity->setHeight($c->height);
    }
}
