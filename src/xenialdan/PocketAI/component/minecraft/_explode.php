<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _explode implements BaseComponent
{
    protected $name = "minecraft:explode";
    private $fuseLength;
    private $fuseLit;
    private $power;
    private $causesFire;

    public function __construct($fuseLength, $fuseLit, $power, $causesFire)
    {
        $this->fuseLength = $fuseLength;
        $this->fuseLit = $fuseLit;
        $this->power = $power;
        $this->causesFire = $causesFire;
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
