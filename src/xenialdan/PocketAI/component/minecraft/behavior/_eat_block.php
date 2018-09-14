<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _eat_block extends BaseComponent
{
    protected $name = "minecraft:behavior.eat_block";
    /** @var mixed (Trigger) $on_eat Trigger to fire when the mob eats a block of grass */
    public $on_eat;

    /**
     * Allows the mob to eat a block (for example, sheep eating grass).
     * _eat_block constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->on_eat = $values['on_eat'] ?? $this->on_eat;

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
