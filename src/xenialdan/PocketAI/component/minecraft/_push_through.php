<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _push_through extends BaseComponent
{
    protected $name = "minecraft:push_through";
    /** @var float $value The value of the entity's push-through, in blocks */
    public $value = 0.0;


    /**
     * Sets the distance through which the entity can push through.
     * _push_through constructor.
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
