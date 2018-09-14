<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _random_fly extends BaseComponent
{
    protected $name = "minecraft:behavior.random_fly";
    /** @var bool $can_land_on_trees If true, the mob can stop flying and land on a tree instead of the ground */
    public $can_land_on_trees = true;
    /** @var int $xz_dist Distance in blocks on ground that the mob will look for a new spot to move to. Must be at least 1 */
    public $xz_dist = 10;
    /** @var int $y_dist Distance in blocks that the mob will look up or down for a new spot to move to. Must be at least 1 */
    public $y_dist = 7;

    /**
     * Allows a mob to randomly fly around.
     * _random_fly constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->can_land_on_trees = $values['can_land_on_trees'] ?? $this->can_land_on_trees;
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
