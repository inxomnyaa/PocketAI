<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _strength implements BaseComponent
{
    protected $name = "minecraft:strength";
    private $max = 5;
    private $min = 1;

    /**
     * Defines the entity's strength to carry items.
     * _strength constructor.
     * @param int $max The maximum strength of this entity
     * @param int $min The initial value of the strength
     */
    public function __construct(int $max, int $min)
    {
        $this->max = $max;
        $this->min = $min;
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
