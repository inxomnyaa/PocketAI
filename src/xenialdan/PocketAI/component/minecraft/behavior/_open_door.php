<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _open_door extends BehaviourComponent
{
    protected $name = "minecraft:behavior.open_door";
    /** @var bool $close_door_after If true, the mob will close the door after opening it and going through it */
    public $close_door_after = true;

    /**
     * Allows the mob to open doors. Requires the mob to be able to path through doors, otherwise the mob won't even want to try opening them.
     * _open_door constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->close_door_after = $values['close_door_after'] ?? $this->close_door_after;

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
