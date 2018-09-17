<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseTrigger;

class _on_ignite extends BaseTrigger
{
    protected $name = "minecraft:on_ignite";

    /**
     * Adds a trigger to call when this entity is set on fire.
     * _on_ignite constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        parent::__construct($values);

    }
}
