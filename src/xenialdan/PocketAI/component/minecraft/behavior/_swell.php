<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _swell extends BaseComponent
{
    protected $name = "minecraft:behavior.swell";
    /** @var float $start_distance This mob starts swelling when a target is at least this many blocks away */
    public $start_distance = 10.0;
    /** @var float $stop_distance This mob stops swelling when a target has moved away at least this many blocks */
    public $stop_distance = 2.0;


    /**
     * Allows the creeper to swell up when a player is nearby. It can only be used by Creepers.
     * _swell constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->start_distance = $values['start_distance'] ?? $this->start_distance;
        $this->stop_distance = $values['stop_distance'] ?? $this->stop_distance;

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
