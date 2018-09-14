<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _shareables extends BaseComponent
{
    protected $name = "minecraft:shareables";
    /** @var string $craft_into Defines the item this entity wants to craft with the item defined above. Should be an item name */
    public $craft_into;
    /** @var string $item The name of the item */
    public $item;
    /** @var int $surplus_amount Number of this item considered extra that the entity wants to share */
    public $surplus_amount = -1;
    /** @var int $want_amount Number of this item this entity wants to share */
    public $want_amount = -1;

    /**
     * Defines a list of items the mob wants to share. Each item must have the following parameters:
     * _shareables constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->craft_into = $values['craft_into'] ?? $this->craft_into;
        $this->item = $values['item'] ?? $this->item;
        $this->surplus_amount = $values['surplus_amount'] ?? $this->surplus_amount;
        $this->want_amount = $values['want_amount'] ?? $this->want_amount;

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
