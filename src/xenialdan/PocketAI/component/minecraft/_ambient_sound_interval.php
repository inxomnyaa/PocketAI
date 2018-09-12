<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _ambient_sound_interval extends BaseComponent
{
    protected $name = "minecraft:ambient_sound_interval";
    /** @var float $range Maximum time is seconds to randomly add to the ambient sound delay time. */
    public $range = 16.0;
    /** @var float $value Minimum time in seconds before the entity plays its ambient sound again */
    public $value = 8.0;


    /**
     * Sets the entity's delay between playing its ambient sound.
     * _ambient_sound_interval constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->range = $values['range'] ?? $this->range;
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
