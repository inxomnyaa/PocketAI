<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _environment_sensor extends BaseComponent
{
    protected $name = "minecraft:environment_sensor";
    /** @var array $on_environment The list of triggers that fire when the environment conditions match the given filter criteria. */
    public $on_environment;


    /**
     * Creates a trigger based on environment conditions.
     * _environment_sensor constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->on_environment = $values['on_environment'] ?? $this->on_environment;

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
