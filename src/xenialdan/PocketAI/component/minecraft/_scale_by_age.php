<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _scale_by_age extends BaseComponent
{
    protected $name = "minecraft:scale_by_age";
    /** @var float $end_scale Ending scale of the entity when it's fully grown */
    public $end_scale = 1.0;
    /** @var float $start_scale Initial scale of the newborn entity */
    public $start_scale = 1.0;

    /**
     * Defines the entity's size interpolation based on the entity's age.
     * _scale_by_age constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->end_scale = $values['end_scale'] ?? $this->end_scale;
        $this->start_scale = $values['start_scale'] ?? $this->start_scale;

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
