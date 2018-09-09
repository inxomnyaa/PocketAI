<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _foot_size implements BaseComponent
{
    protected $name = "minecraft:foot_size";
    private $value = 0.5;

    /**
     * Sets the number of blocks the entity can step without jumping.
     * _foot_size constructor.
     * @param float $value The value of the size of the entity's step
     */
    public function __construct(float $value)
    {
        $this->value = $value;
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
