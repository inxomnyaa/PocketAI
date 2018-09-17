<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseTrigger;

class _on_target_escape extends BaseTrigger
{
    protected $name = "minecraft:on_target_escape";

    /**
     * Adds a trigger to call when this entity loses the target it currently has.
     * _on_target_escape constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        parent::__construct($values);

    }
}
