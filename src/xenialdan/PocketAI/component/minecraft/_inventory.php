<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;
use xenialdan\PocketAI\inventory\AIEntityInventory;

class _inventory extends BaseComponent
{
    protected $name = "minecraft:inventory";
    /** @var int $additional_slots_per_strength Number of slots that this entity can gain per extra strength */
    public $additional_slots_per_strength;
    /** @var bool $can_be_siphoned_from If true, the contents of this inventory can be removed by a hopper */
    public $can_be_siphoned_from = false;
    /** @var string $container_type Type of container this entity has. Can be horse, minecart_chest, minecart_hopper, inventory, container or hopper */
    public $container_type = "none";
    /** @var int $inventory_size Number of slots the container has */
    public $inventory_size = 5;
    /** @var int $linked_slots_size Number of linked slots (e.g. Player Hotbar) the container has */
    public $linked_slots_size;
    /** @var bool $private If true, only the entity can access the inventory */
    public $private = false;
    /** @var bool $restrict_to_owner If true, the entity's inventory can only be accessed by its owner or itself */
    public $restrict_to_owner = false;


    /**
     * Defines this entity's inventory properties.
     * _inventory constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->additional_slots_per_strength = $values['additional_slots_per_strength'] ?? $this->additional_slots_per_strength;
        $this->can_be_siphoned_from = $values['can_be_siphoned_from'] ?? $this->can_be_siphoned_from;
        $this->container_type = $values['container_type'] ?? $this->container_type;
        $this->inventory_size = $values['inventory_size'] ?? $this->inventory_size;
        $this->linked_slots_size = $values['linked_slots_size'] ?? $this->linked_slots_size;
        $this->private = $values['private'] ?? $this->private;
        $this->restrict_to_owner = $values['restrict_to_owner'] ?? $this->restrict_to_owner;

    }

    /**
     * Applies the changes to the mob
     * @param AIEntity|AIProjectile $entity
     */
    public function apply($entity): void
    {
        // TODO: Extend apply() method.
        try {
            if($this->container_type !== "none")
                $entity->setInventory(new AIEntityInventory($entity, [], $this->inventory_size, null, $this->container_type));
        } catch (\Exception $e) {
            //TODO
        }
    }

    /**
     * Removes the changes from the mob
     * @param AIEntity|AIProjectile $entity
     */
    public function remove($entity): void
    {
        // TODO: Extend remove() method.
        $entity->setInventory(null);
    }
}
