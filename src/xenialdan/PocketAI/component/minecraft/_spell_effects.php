<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _spell_effects extends BaseComponent
{
    protected $name = "minecraft:spell_effects";
    /** @var array $add_effects List of effects to add to this entity after adding this component
     * ;Parameters
     *
     * : { */
            public $add_effects;
            /** @var string $effect Effect to add to this entity. Includes 'duration' in seconds, 'amplifier' level, 'ambient' if it is to be considered an ambient effect, and 'visible' if the effect should be visible */
            public $effect;
            /** @var string $remove_effects List of names of effects to be removed from this entity after adding this component */
            public $remove_effects;
            

    /**
     * Defines what mob effects to add and remove to the entity when adding this component.
     * _spell_effects constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->add_effects = $values['add_effects'] ?? $this->add_effects;
        $this->effect = $values['effect'] ?? $this->effect;
        $this->remove_effects = $values['remove_effects'] ?? $this->remove_effects;

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
