<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseTrigger;

class _on_hurt extends BaseTrigger
{
    protected $name = "minecraft:on_hurt";

    /**
     * Adds a trigger to call when this entity takes damage.
     * _on_hurt constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        parent::__construct($values);

    }
}
