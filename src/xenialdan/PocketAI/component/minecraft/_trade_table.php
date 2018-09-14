<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _trade_table extends BaseComponent
{
    protected $name = "minecraft:trade_table";
    /** @var string $display_name Name to be displayed while trading with this entity */
    public $display_name;
    /** @var string $table File path relative to the resource pack root for this entity's trades */
    public $table;

    /**
     * Defines this entity's ability to trade with players.
     * _trade_table constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->display_name = $values['display_name'] ?? $this->display_name;
        $this->table = $values['table'] ?? $this->table;

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
