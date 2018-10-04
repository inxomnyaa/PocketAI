<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _leap_at_target extends BehaviourComponent
{
    protected $name = "minecraft:behavior.leap_at_target";
    /** @var bool $must_be_on_ground If true, the mob will only jump at its target if its on the ground. Setting it to false will allow it to jump even if its already in the air */
    public $must_be_on_ground = true;
    /** @var float $yd The height in blocks the mob jumps when leaping at its target */
    public $yd = 0.0;

    /**
     * Allows monsters to jump at and attack their target. Can only be used by hostile mobs.
     * _leap_at_target constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->must_be_on_ground = $values['must_be_on_ground'] ?? $this->must_be_on_ground;
        $this->yd = $values['yd'] ?? $this->yd;

        parent::__construct($values);
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

    public function tick(int $tickDiff)
    {
        // TODO: Implement tick() method.
    }
}
