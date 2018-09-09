<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _mark_variant implements BaseComponent
{
    protected $name = "minecraft:mark_variant";
    private $value = 0;

    /**
     * Additional variant value. Can be used to further differentiate variants.
     * _mark_variant constructor.
     * @param int $value The ID of the variant. By convention, 0 is the ID of the base entity
     */
    public function __construct(int $value)
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
