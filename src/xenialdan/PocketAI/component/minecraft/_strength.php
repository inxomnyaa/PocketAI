<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _strength extends BaseComponent
{
    protected $name = "minecraft:strength";
    /** @var int $max The maximum strength of this entity */
    public $max = 5;
    /** @var int $value The initial value of the strength */
    public $value = 1;


    /**
     * Defines the entity's strength to carry items.
     * _strength constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->max = $values['max'] ?? $this->max;
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
