<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _is_baby extends BaseComponent
{
    protected $name = "minecraft:is_baby";

    /**
     * Sets that this entity is a baby.
     * _is_baby constructor.
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
        $entity->setGenericFlag(AIEntity::DATA_FLAG_BABY, true);
    }

    /**
     * Removes the changes from the mob
     * @param AIEntity|AIProjectile $entity
     */
    public function remove($entity): void
    {
        $entity->setGenericFlag(AIEntity::DATA_FLAG_BABY, false);
    }
}
