<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _spell_effects implements BaseComponent
{
    protected $name = "minecraft:spell_effects";
    private $add_effects;
    private $remove_effects = "";

    /**
     * Defines what mob effects to add and remove to the entity when adding this component.
     * _spell_effects constructor.
     * @param array $add_effects List of effects to add to this entity after adding this component
     * @param string$remove_effects List of names of effects to be removed from this entity after adding this component
     */
    public function __construct(array $add_effects, string $remove_effects)
    {
        $this->add_effects = $add_effects;
        $this->remove_effects = $remove_effects;
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
