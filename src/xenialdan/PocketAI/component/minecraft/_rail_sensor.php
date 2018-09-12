<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _rail_sensor extends BaseComponent
{
    protected $name = "minecraft:rail_sensor";
    /** @var bool $check_block_types If true, on tick this entity will trigger its on_deactivate behavior */
    public $check_block_types = false;
    /** @var bool $eject_on_activate If true, this entity will eject all of its riders when it passes over an activated rail */
    public $eject_on_activate = true;
    /** @var bool $eject_on_deactivate If true, this entity will eject all of its riders when it passes over a deactivated rail */
    public $eject_on_deactivate = false;
    /** @var string $on_activate Event to call when the rail is activated */
    public $on_activate;
    /** @var string $on_deactivate Event to call when the rail is deactivated */
    public $on_deactivate;
    /** @var bool $tick_command_block_on_activate If true, command blocks will start ticking when passing over an activated rail */
    public $tick_command_block_on_activate = true;
    /** @var bool $tick_command_block_on_deactivate If false, command blocks will stop ticking when passing over a deactivated rail */
    public $tick_command_block_on_deactivate = false;


    /**
     * Defines the behavior of the entity when the rail gets activated or deactivated.
     * _rail_sensor constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->check_block_types = $values['check_block_types'] ?? $this->check_block_types;
        $this->eject_on_activate = $values['eject_on_activate'] ?? $this->eject_on_activate;
        $this->eject_on_deactivate = $values['eject_on_deactivate'] ?? $this->eject_on_deactivate;
        $this->on_activate = $values['on_activate'] ?? $this->on_activate;
        $this->on_deactivate = $values['on_deactivate'] ?? $this->on_deactivate;
        $this->tick_command_block_on_activate = $values['tick_command_block_on_activate'] ?? $this->tick_command_block_on_activate;
        $this->tick_command_block_on_deactivate = $values['tick_command_block_on_deactivate'] ?? $this->tick_command_block_on_deactivate;

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
