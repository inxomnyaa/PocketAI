<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _breathable implements BaseComponent
{
    protected $name = "minecraft:breathable";
    private $totalSupply;
    private $suffocateTime;

    public function __construct($totalSupply, $suffocateTime)
    {
        $this->totalSupply = $totalSupply;
        $this->suffocateTime = $suffocateTime;
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
