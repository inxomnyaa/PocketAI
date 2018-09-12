<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _random_stroll extends BaseComponent
{
    protected $name = "minecraft:behavior.random_stroll";
    /** @var int $xz_dist Distance in blocks on ground that the mob will look for a new spot to move to. Must be at least 1 */
    public $xz_dist = 10;
    /** @var int $y_dist Distance in blocks that the mob will look up or down for a new spot to move to. Must be at least 1 */
    public $y_dist = 7;


    /**
     * Allows a mob to randomly stroll around.
     * _random_stroll constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->xz_dist = $values['xz_dist'] ?? $this->xz_dist;
        $this->y_dist = $values['y_dist'] ?? $this->y_dist;

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
