<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _nameable extends BaseComponent
{
    protected $name = "minecraft:nameable";
    /** @var bool $allowNameTagRenaming If true, this entity can be renamed with name tags */
    public $allowNameTagRenaming = true;
    /** @var bool $alwaysShow If true, the name will always be shown */
    public $alwaysShow = false;
    /** @var string $default_trigger Trigger to run when the entity gets named */
    public $default_trigger;
    /** @var mixed (JSON Object) $name_actions Describes the special names for this entity and the events to call when the entity acquires those names
     * ;Parameters
     *
     * : { */
            public $name_actions;
            /** @var string $name_filter List of special names that will cause the events defined in 'on_named' to fire */
            public $name_filter;
            /** @var string $on_named Event to be called when this entity acquires the name specified in 'name_filter' */
            public $on_named;
            

    /**
     * Allows this entity to be named (e.g. using a name tag)
     * _nameable constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->allowNameTagRenaming = $values['allowNameTagRenaming'] ?? $this->allowNameTagRenaming;
        $this->alwaysShow = $values['alwaysShow'] ?? $this->alwaysShow;
        $this->default_trigger = $values['default_trigger'] ?? $this->default_trigger;
        $this->name_actions = $values['name_actions'] ?? $this->name_actions;
        $this->name_filter = $values['name_filter'] ?? $this->name_filter;
        $this->on_named = $values['on_named'] ?? $this->on_named;

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
