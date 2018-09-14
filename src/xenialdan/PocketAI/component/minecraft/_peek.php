<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _peek extends BaseComponent
{
    protected $name = "minecraft:peek";
    /** @var string $on_close Event to call when the entity is done peeking */
    public $on_close;
    /** @var string $on_open Event to call when the entity starts peeking */
    public $on_open;
    /** @var string $on_target_open Event to call when the entity's target entity starts peeking */
    public $on_target_open;

    /**
     * Defines the entity's 'peek' behavior, defining the events that should be called during it
     * _peek constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->on_close = $values['on_close'] ?? $this->on_close;
        $this->on_open = $values['on_open'] ?? $this->on_open;
        $this->on_target_open = $values['on_target_open'] ?? $this->on_target_open;

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
