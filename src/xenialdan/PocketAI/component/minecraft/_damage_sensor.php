<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _damage_sensor extends BaseComponent
{
    protected $name = "minecraft:damage_sensor";
    /** @var string $cause Type of damage that triggers this set of events */
    public $cause;
    /** @var bool $deals_damage If true, the damage dealt to the entity will take off health from it. Set to false to make the entity ignore that damage */
    public $deals_damage = true;
    /** @var array $on_damage List of triggers with the events to call when taking this specific kind of damage. Allows specifying filters for entity definitions and events */
    public $on_damage;

    /**
     * Defines what events to call when this entity is damaged by specific entities or items. Can be either an array or a single instance.
     * _damage_sensor constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->cause = $values['cause'] ?? $this->cause;
        $this->deals_damage = $values['deals_damage'] ?? $this->deals_damage;
        $this->on_damage = $values['on_damage'] ?? $this->on_damage;

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
