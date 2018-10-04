<?php

namespace xenialdan\PocketAI\component\minecraft\navigation;

use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _walk extends NavigationComponent
{
    protected $name = "minecraft:navigation.walk";

    /**
     * Allows this entity to generate paths by walking around and jumping up and down a block like regular mobs.
     * _walk constructor.
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
}
