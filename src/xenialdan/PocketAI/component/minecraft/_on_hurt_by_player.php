<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseTrigger;

class _on_hurt_by_player extends BaseTrigger
{
    protected $name = "minecraft:on_hurt_by_player";

    /**
     * Adds a trigger to call when this entity is attacked by the player.
     * _on_hurt_by_player constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        parent::__construct($values);

    }
}
