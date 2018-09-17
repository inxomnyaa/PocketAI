<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseTrigger;

class _on_start_takeoff extends BaseTrigger
{
    protected $name = "minecraft:on_start_takeoff";

    /**
     * Only usable by the Ender Dragon. Adds a trigger to call when this entity starts flying.
     * _on_start_takeoff constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        parent::__construct($values);

    }
}
