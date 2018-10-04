<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _wither_random_attack_pos_goal extends BehaviourComponent
{
    protected $name = "minecraft:behavior.wither_random_attack_pos_goal";

    /**
     * Allows the wither to launch random attacks. Can only be used by the Wither Boss.
     * _wither_random_attack_pos_goal constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {

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
