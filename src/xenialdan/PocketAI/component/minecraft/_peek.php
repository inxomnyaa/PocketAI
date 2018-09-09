<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _peek implements BaseComponent
{
    protected $name = "minecraft:peek";
    private $on_open;
    private $on_close;
    private $on_target_open;

    public function __construct($on_open, $on_close, $on_target_open)
    {
        $this->on_open = $on_open;
        $this->on_close = $on_close;
        $this->on_target_open = $on_target_open;
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
