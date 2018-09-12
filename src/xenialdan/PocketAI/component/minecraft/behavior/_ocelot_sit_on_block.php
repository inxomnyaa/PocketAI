<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _ocelot_sit_on_block extends BaseComponent
{
    protected $name = "minecraft:behavior.ocelot_sit_on_block";
    /** @var float $speed_multiplier Movement speed multiplier of the mob when using this AI Goal */
    public $speed_multiplier = 1.0;


    /**
     * Allows to mob to be able to sit in place like the ocelot.
     * _ocelot_sit_on_block constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->speed_multiplier = $values['speed_multiplier'] ?? $this->speed_multiplier;

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
