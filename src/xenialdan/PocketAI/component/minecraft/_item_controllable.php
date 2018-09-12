<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _item_controllable extends BaseComponent
{
    protected $name = "minecraft:item_controllable";
    /** @var array $control_items List of items that can be used to control this entity */
    public $control_items;


    /**
     * Defines what items can be used to control this entity while ridden
     * _item_controllable constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->control_items = $values['control_items'] ?? $this->control_items;

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
