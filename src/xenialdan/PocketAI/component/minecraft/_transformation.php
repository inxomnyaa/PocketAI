<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _transformation extends BaseComponent
{
    protected $name = "minecraft:transformation";
    /** @var mixed (JSON Object) $add List of components to add to the entity after the transformation
     * ;Parameters
     *
     * : { */
            public $add;
            /** @var array $component_groups Names of component groups to add */
            public $component_groups;
            /** @var string $begin_transform_sound Sound to play when the transformation starts */
            public $begin_transform_sound;
            /** @var mixed (JSON Object) $delay Defines the properties of the delay for the transformation
             * ;Parameters
             *
             * : { */
            public $delay;
            /** @var float $block_assist_chance Chance that the entity will look for nearby blocks that can speed up the transformation. Value must be between 0.0 and 1.0 */
            public $block_assist_chance = 0.0;
            /** @var float $block_chance Chance that, once a block is found, will help speed up the transformation */
            public $block_chance = 0.0;
            /** @var int $block_max Maximum number of blocks the entity will look for to aid in the transformation. If not defined or set to 0, it will be set to the block radius */
            public $block_max;
            /** @var int $block_radius Distance in Blocks that the entity will search for blocks that can help the transformation */
            public $block_radius;
            /** @var array $block_types List of blocks that can help the transformation of this entity */
            public $block_types;
            /** @var float $value Time in seconds before the entity transforms */
            public $value = 0.0;
            /** @var string $into Entity Definition that this entity will transform into */
            public $into;
            /** @var string $transformation_sound Sound to play when the entity is done transforming */
            public $transformation_sound;
            

    /**
     * Defines an entity's transformation from the current definition into another
     * _transformation constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->add = $values['add'] ?? $this->add;
        $this->component_groups = $values['component_groups'] ?? $this->component_groups;
        $this->begin_transform_sound = $values['begin_transform_sound'] ?? $this->begin_transform_sound;
        $this->delay = $values['delay'] ?? $this->delay;
        $this->block_assist_chance = $values['block_assist_chance'] ?? $this->block_assist_chance;
        $this->block_chance = $values['block_chance'] ?? $this->block_chance;
        $this->block_max = $values['block_max'] ?? $this->block_max;
        $this->block_radius = $values['block_radius'] ?? $this->block_radius;
        $this->block_types = $values['block_types'] ?? $this->block_types;
        $this->value = $values['value'] ?? $this->value;
        $this->into = $values['into'] ?? $this->into;
        $this->transformation_sound = $values['transformation_sound'] ?? $this->transformation_sound;

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
