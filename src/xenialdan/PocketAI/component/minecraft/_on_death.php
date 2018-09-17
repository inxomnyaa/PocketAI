<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseTrigger;

class _on_death extends BaseTrigger
{
    protected $name = "minecraft:on_death";

    /**
     * Only usable by the Ender Dragon. Adds a trigger to call on this entity's death.
     * _on_death constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        parent::__construct($values);

    }
}
