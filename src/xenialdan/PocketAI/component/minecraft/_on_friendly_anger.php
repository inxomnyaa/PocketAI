<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseTrigger;

class _on_friendly_anger extends BaseTrigger
{
    protected $name = "minecraft:on_friendly_anger";

    /**
     * Adds a trigger that will run when a nearby entity of the same type as this entity becomes Angry.
     * _on_friendly_anger constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        parent::__construct($values);

    }
}
