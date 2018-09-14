<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _interact extends BaseComponent
{
    protected $name = "minecraft:interact";
    /** @var mixed (JSON Object) $add_items Loot table with items to add to the player's inventory upon successful interaction
     * ;Parameters
     *
     */
    public $add_items;
    /** @var string $table File path, relative to the Behavior Pack's path, to the loot table file */
    public $table;
    /** @var float $cooldown Time in seconds before this entity can be interacted with again */
    public $cooldown = 0.0;
    /** @var int $hurt_item The amount of damage the item will take when used to interact with this entity. A value of 0 means the item won't lose durability */
    public $hurt_item;
    /** @var string $interact_text Text to show when the player is able to interact in this way with this entity when playing with Touch-screen controls */
    public $interact_text;
    /** @var mixed $on_interact Event to fire when the interaction occurs */
    public $on_interact;
    /** @var string $play_sounds List of sounds to play when the interaction occurs */
    public $play_sounds;
    /** @var string $spawn_entities List of entities to spawn when the interaction occurs */
    public $spawn_entities;
    /** @var mixed (JSON Object) $spawn_items Loot table with items to drop on the ground upon successful interaction
     * ;Parameters
     *
     */
    public $spawn_items;
    /** @var bool $swing If true, the player will do the 'swing' animation when interacting with this entity */
    public $swing = false;
    /** @var string $transform_to_item The item used will transform to this item upon successful interaction. Format: itemName:auxValue */
    public $transform_to_item;
    /** @var bool $use_item If true, the interaction will use an item */
    public $use_item = false;


    /**
     * Defines interactions with this entity.
     * _interact constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->add_items = $values['add_items'] ?? $this->add_items;
        $this->table = $values['table'] ?? $this->table;
        $this->cooldown = $values['cooldown'] ?? $this->cooldown;
        $this->hurt_item = $values['hurt_item'] ?? $this->hurt_item;
        $this->interact_text = $values['interact_text'] ?? $this->interact_text;
        $this->on_interact = $values['on_interact'] ?? $this->on_interact;
        $this->play_sounds = $values['play_sounds'] ?? $this->play_sounds;
        $this->spawn_entities = $values['spawn_entities'] ?? $this->spawn_entities;
        $this->spawn_items = $values['spawn_items'] ?? $this->spawn_items;
        $this->swing = $values['swing'] ?? $this->swing;
        $this->transform_to_item = $values['transform_to_item'] ?? $this->transform_to_item;
        $this->use_item = $values['use_item'] ?? $this->use_item;

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
