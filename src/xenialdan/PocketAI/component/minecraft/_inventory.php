<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _inventory implements BaseComponent
{
    protected $name = "minecraft:inventory";
    private $container_type;
    private $inventory_size;
    private $can_be_siphoned_from;

    public function __construct($container_type, $inventory_size, $can_be_siphoned_from)
    {
        $this->container_type = $container_type;
        $this->inventory_size = $inventory_size;
        $this->can_be_siphoned_from = $can_be_siphoned_from;
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
