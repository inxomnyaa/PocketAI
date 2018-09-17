<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseTrigger;

class _on_target_acquired extends BaseTrigger
{
    protected $name = "minecraft:on_target_acquired";

    /**
     * Adds a trigger to call when this entity finds a target.
     * _on_target_acquired constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        parent::__construct($values);

    }
}
