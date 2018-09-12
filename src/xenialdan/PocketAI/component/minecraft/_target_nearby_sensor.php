<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _target_nearby_sensor extends BaseComponent
{
    protected $name = "minecraft:target_nearby_sensor";
    /** @var float $inside_range Maximum distance in blocks that another entity will be considered in the 'inside' range */
    public $inside_range = 1.0;
    /** @var string $on_inside_range Event to call when an entity gets in the inside range. Can specify 'event' for the name of the event and 'target' for the target of the event */
    public $on_inside_range;
    /** @var string $on_outside_range Event to call when an entity gets in the outside range. Can specify 'event' for the name of the event and 'target' for the target of the event */
    public $on_outside_range;
    /** @var float $outside_range Maximum distance in blocks that another entity will be considered in the 'outside' range */
    public $outside_range = 5.0;


    /**
     * Defines the entity's range within which it can see or sense other entities to target them.
     * _target_nearby_sensor constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->inside_range = $values['inside_range'] ?? $this->inside_range;
        $this->on_inside_range = $values['on_inside_range'] ?? $this->on_inside_range;
        $this->on_outside_range = $values['on_outside_range'] ?? $this->on_outside_range;
        $this->outside_range = $values['outside_range'] ?? $this->outside_range;

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
