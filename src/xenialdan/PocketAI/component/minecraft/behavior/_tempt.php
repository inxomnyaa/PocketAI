<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _tempt extends BaseComponent
{
    protected $name = "minecraft:behavior.tempt";
    /** @var bool $can_get_scared If true, the mob can stop being tempted if the player moves too fast while close to this mob */
    public $can_get_scared = false;
    /** @var array $items List of items this mob is tempted by */
    public $items;
    /** @var float $speed_multiplier Movement speed multiplier of the mob when using this AI Goal */
    public $speed_multiplier = 1.0;
    /** @var float $within_radius Distance in blocks this mob can get tempted by a player holding an item they like */
    public $within_radius = 0.0;


    /**
     * Allows the mob to be tempted by food they like.
     * _tempt constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->can_get_scared = $values['can_get_scared'] ?? $this->can_get_scared;
        $this->items = $values['items'] ?? $this->items;
        $this->speed_multiplier = $values['speed_multiplier'] ?? $this->speed_multiplier;
        $this->within_radius = $values['within_radius'] ?? $this->within_radius;

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
