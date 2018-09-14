<?php

namespace xenialdan\PocketAI\component\minecraft\movement;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _fly extends BaseComponent
{
    protected $name = "minecraft:movement.fly";
    /** @var float $max_turn The maximum number in degrees the mob can turn per tick. */
    public $max_turn = 30.0;

    /**
     * This move control causes the mob to fly.
     * _fly constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->max_turn = $values['max_turn'] ?? $this->max_turn;

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
