<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _is_dyeable extends BaseComponent
{
    protected $name = "minecraft:is_dyeable";
    /** @var string $interact_text The text that will display when interacting with this entity with a dye when playing with Touch-screen controls */
    public $interact_text;

    /**
     * Allows dyes to be used on this entity to change its color.
     * _is_dyeable constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->interact_text = $values['interact_text'] ?? $this->interact_text;

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
