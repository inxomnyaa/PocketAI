<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _walk_animation_speed extends BaseComponent
{
    protected $name = "minecraft:walk_animation_speed";
    /** @var float $value The higher the number, the faster the animation for walking plays. A value of 1.0 means normal speed, while 2.0 means twice as fast */
    public $value = 1.0;


    /**
     * Sets the speed multiplier for this entity's walk animation speed.
     * _walk_animation_speed constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->value = $values['value'] ?? $this->value;

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
