<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _is_tamed extends BaseComponent
{
    protected $name = "minecraft:is_tamed";

    /**
     * Sets that this entity is currently tamed.
     * _is_tamed constructor.
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
        $entity->setGenericFlag(AIEntity::DATA_FLAG_TAMED, true);
    }

    /**
     * Removes the changes from the mob
     * @param AIEntity|AIProjectile $entity
     */
    public function remove($entity): void
    {
        $entity->setGenericFlag(AIEntity::DATA_FLAG_TAMED, false);
    }
}
