<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _leashable implements BaseComponent
{
    protected $name = "minecraft:leashable";
    private $soft_distance;
    private $hard_distance;
    private $max_distance;
    private $on_leash;
    private $on_unleash;

    public function __construct($soft_distance, $hard_distance, $max_distance, $on_leash, $on_unleash)
    {
        $this->soft_distance = $soft_distance;
        $this->hard_distance = $hard_distance;
        $this->max_distance = $max_distance;
        $this->on_leash = $on_leash;
        $this->on_unleash = $on_unleash;
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
