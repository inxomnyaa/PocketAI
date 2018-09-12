<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _leashable extends BaseComponent
{
    protected $name = "minecraft:leashable";
    /** @var float $hard_distance Distance in blocks at which the leash stiffens, restricting movement */
    public $hard_distance = 6.0;
    /** @var float $max_distance Distance in blocks at which the leash breaks */
    public $max_distance = 10.0;
    /** @var string $on_leash Event to call when this entity is leashed */
    public $on_leash;
    /** @var string $on_unleash Event to call when this entity is unleashed */
    public $on_unleash;
    /** @var float $soft_distance Distance in blocks at which the 'spring' effect starts acting to keep this entity close to the entity that leashed it */
    public $soft_distance = 4.0;


    /**
     * Allows this entity to be leashed and Defines the conditions and events for this entity when is leashed.
     * _leashable constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->hard_distance = $values['hard_distance'] ?? $this->hard_distance;
        $this->max_distance = $values['max_distance'] ?? $this->max_distance;
        $this->on_leash = $values['on_leash'] ?? $this->on_leash;
        $this->on_unleash = $values['on_unleash'] ?? $this->on_unleash;
        $this->soft_distance = $values['soft_distance'] ?? $this->soft_distance;

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
