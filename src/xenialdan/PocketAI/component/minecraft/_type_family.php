<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _type_family extends BaseComponent
{
    protected $name = "minecraft:type_family";
    /** @var array $family List of family names */
    public $family;

    /**
     * Defines the families this entity belongs to.
     * _type_family constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->family = $values['family'] ?? $this->family;

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
