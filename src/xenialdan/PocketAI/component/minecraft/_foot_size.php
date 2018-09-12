<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _foot_size extends BaseComponent
{
    protected $name = "minecraft:foot_size";
    /** @var float $value The value of the size of the entity's step */
    public $value = 0.5;


    /**
     * Sets the number of blocks the entity can step without jumping.
     * _foot_size constructor.
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
