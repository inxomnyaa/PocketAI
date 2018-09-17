<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;
use xenialdan\PocketAI\filter\Filters;

class _healable extends BaseComponent
{
    protected $name = "minecraft:healable";
    /** @var array $items The list of items that can be used to heal this entity
     * ;Parameters
     *
     */
    public $items;
    /** @var string (Minecraft Filter) $filters The list of conditions for this trigger */
    public $filters;
    /** @var bool $force_use Determines if item can be used regardless of entity being full health */
    public $force_use = false;
    /** @var float $heal_amount The amount of health this entity gains when fed this item */
    public $heal_amount = 1.0;
    /** @var string $item Name of the item this entity likes and can be used to heal this entity */
    public $item;

    /**
     * Defines the interactions with this entity for healing it.
     * _healable constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->items = $values['items'] ?? $this->items;
        $this->filters = $values['filters'] ?? $this->filters;
        $this->force_use = $values['force_use'] ?? $this->force_use;
        $this->heal_amount = $values['heal_amount'] ?? $this->heal_amount;
        $this->item = $values['item'] ?? $this->item;

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
