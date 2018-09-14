<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _spawn_entity extends BaseComponent
{
    protected $name = "minecraft:spawn_entity";
    /** @var int $max_wait_time Maximum amount of time to randomly wait in seconds before another entity is spawned */
    public $max_wait_time = 600;
    /** @var int $min_wait_time Minimum amount of time to randomly wait in seconds before another entity is spawned */
    public $min_wait_time = 300;
    /** @var string $spawn_entity Identifier of the entity to spawn. Leave empty to spawn the item defined above instead */
    public $spawn_entity;
    /** @var string $spawn_event Event to call when the entity is spawned */
    public $spawn_event = "''minecraft:''entity_born";
    /** @var string $spawn_item Name of the item to spawn */
    public $spawn_item = "egg";
    /** @var string $spawn_method Method to use to spawn the entity */
    public $spawn_method = "born";
    /** @var string $spawn_sound Name of the sound effect to play when the entity is spawned */
    public $spawn_sound = "plop";

    /**
     * Adds a timer after which this entity will spawn another entity or item (similar to vanilla's chicken's egg-laying behavior).
     * _spawn_entity constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->max_wait_time = $values['max_wait_time'] ?? $this->max_wait_time;
        $this->min_wait_time = $values['min_wait_time'] ?? $this->min_wait_time;
        $this->spawn_entity = $values['spawn_entity'] ?? $this->spawn_entity;
        $this->spawn_event = $values['spawn_event'] ?? $this->spawn_event;
        $this->spawn_item = $values['spawn_item'] ?? $this->spawn_item;
        $this->spawn_method = $values['spawn_method'] ?? $this->spawn_method;
        $this->spawn_sound = $values['spawn_sound'] ?? $this->spawn_sound;

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
