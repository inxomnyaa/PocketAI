<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _color extends BaseComponent
{
    protected $name = "minecraft:color";
    /** @var int $value The Palette Color value of the entity */
    public $value;


    /**
     * Defines the entity's color. Only works on vanilla entities that have predefined color values (sheep, llama, shulker).
     * _color constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->value = $values['value'] ?? $this->value;

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
