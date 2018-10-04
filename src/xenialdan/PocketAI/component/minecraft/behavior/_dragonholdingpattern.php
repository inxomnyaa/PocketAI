<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _dragonholdingpattern extends BehaviourComponent
{
    protected $name = "minecraft:behavior.dragonholdingpattern";

    /**
     * Allows the Dragon to fly around in a circle around the center podium. Can only be used by the Ender Dragon.
     * _dragonholdingpattern constructor.
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
