<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _can_climb extends BaseComponent
{
    protected $name = "minecraft:can_climb";


    /**
     * Allows this entity to climb up ladders.
     * _can_climb constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {

    }

    /**
     * Applies the changes to the mob
     * @param AIEntity|AIProjectile $entity
     */
    public function apply($entity): void
    {
        $entity->setCanClimb(true);
    }

    /**
     * Removes the changes from the mob
     * @param AIEntity|AIProjectile $entity
     */
    public function remove($entity): void
    {
        $entity->setCanClimb(false);
    }
}
