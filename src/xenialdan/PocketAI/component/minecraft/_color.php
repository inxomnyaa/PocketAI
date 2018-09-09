<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _color implements BaseComponent
{
    protected $name = "minecraft:color";
    private $value = 0;


    /**
     * Defines the entity's color. Only works on vanilla entities that have predefined color values (sheep, llama, shulker).
     * _color constructor.
     * @param int $value The Palette Color value of the entity
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
