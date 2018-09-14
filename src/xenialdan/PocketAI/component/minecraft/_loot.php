<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;
use xenialdan\PocketAI\LootGenerator;

class _loot extends BaseComponent
{
    protected $name = "minecraft:loot";
    /** @var string $table The path to the loot table, relative to the Behavior Pack's root */
    public $table;

    /**
     * Sets the loot table for what items this entity drops upon death.
     * _loot constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->table = $values['table'] ?? $this->table;

    }

    /**
     * Applies the changes to the mob
     * @param AIEntity|AIProjectile $entity
     */
    public function apply($entity): void
    {
        $entity->setLootGenerator(new LootGenerator($this->table, $entity));
    }

    /**
     * Removes the changes from the mob
     * @param AIEntity|AIProjectile $entity
     */
    public function remove($entity): void
    {
        $entity->setLootGenerator(new LootGenerator("empty", $entity));
    }
}
