<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _shooter extends BaseComponent
{
    protected $name = "minecraft:shooter";
    /** @var int $auxVal ID of the Potion effect to be applied on hit */
    public $auxVal = -1;
    /** @var string $def Entity definition to use as projectile for the ranged attack. The entity definition must have the projectile component to be able to be shot as a projectile */
    public $def;

    /**
     * Defines the entity's ranged attack behavior.
     * _shooter constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->auxVal = $values['auxVal'] ?? $this->auxVal;
        $this->def = $values['def'] ?? $this->def;

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
