<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _equippable extends BaseComponent
{
    protected $name = "minecraft:equippable";
    /** @var array $slots List of slots and the item that can be equipped
     * ;Parameters
     *
     */
    public $slots;
    /** @var array $accepted_items The list of items that can go in this slot */
    public $accepted_items;
    /** @var string $interact_text Text to be displayed when the entity can be equipped with this item when playing with Touch-screen controls */
    public $interact_text;
    /** @var string $item Name of the item that can be equipped for this slot */
    public $item;
    /** @var string $on_equip Event to trigger when this entity is equipped with this item */
    public $on_equip;
    /** @var string $on_unequip Event to trigger when this item is removed from this entity */
    public $on_unequip;
    /** @var int $slot The slot number of this slot */
    public $slot;


    /**
     * Defines an entity's behavior for having items equipped to it
     * _equippable constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->slots = $values['slots'] ?? $this->slots;
        $this->accepted_items = $values['accepted_items'] ?? $this->accepted_items;
        $this->interact_text = $values['interact_text'] ?? $this->interact_text;
        $this->item = $values['item'] ?? $this->item;
        $this->on_equip = $values['on_equip'] ?? $this->on_equip;
        $this->on_unequip = $values['on_unequip'] ?? $this->on_unequip;
        $this->slot = $values['slot'] ?? $this->slot;

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
