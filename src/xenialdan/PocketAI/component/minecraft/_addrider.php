<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _addrider extends BaseComponent
{
    protected $name = "minecraft:addrider";
    /** @var string $entity_type The entity type that will be riding this entity */
    public $entity_type;


    /**
     * Adds a rider to the entity. Requires ''minecraft:''rideable.
     * _addrider constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->entity_type = $values['entity_type'] ?? $this->entity_type;

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
