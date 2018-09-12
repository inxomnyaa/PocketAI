<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _breathable extends BaseComponent
{
    protected $name = "minecraft:breathable";
    /** @var array $breatheBlocks List of blocks this entity can breathe in, in addition to the above */
    public $breatheBlocks;
    /** @var bool $breathesAir If true, this entity can breathe in air */
    public $breathesAir = true;
    /** @var bool $breathesLava If true, this entity can breathe in lava */
    public $breathesLava = false;
    /** @var bool $breathesSolids If true, this entity can breathe in solid blocks */
    public $breathesSolids = false;
    /** @var bool $breathesWater If true, this entity can breathe in water */
    public $breathesWater = false;
    /** @var bool $generatesBubbles If true, this entity will have visible bubbles while in water */
    public $generatesBubbles = true;
    /** @var array $nonBreatheBlocks List of blocks this entity can't breathe in, in addition to the above */
    public $nonBreatheBlocks;
    /** @var int $suffocateTime Time in seconds between suffocation damage */
    public $suffocateTime = -20;
    /** @var int $totalSupply Time in seconds the entity can hold its breath */
    public $totalSupply = 15;


    /**
     * Defines what blocks this entity can breathe in and gives them the ability to suffocate
     * _breathable constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->breatheBlocks = $values['breatheBlocks'] ?? $this->breatheBlocks;
        $this->breathesAir = $values['breathesAir'] ?? $this->breathesAir;
        $this->breathesLava = $values['breathesLava'] ?? $this->breathesLava;
        $this->breathesSolids = $values['breathesSolids'] ?? $this->breathesSolids;
        $this->breathesWater = $values['breathesWater'] ?? $this->breathesWater;
        $this->generatesBubbles = $values['generatesBubbles'] ?? $this->generatesBubbles;
        $this->nonBreatheBlocks = $values['nonBreatheBlocks'] ?? $this->nonBreatheBlocks;
        $this->suffocateTime = $values['suffocateTime'] ?? $this->suffocateTime;
        $this->totalSupply = $values['totalSupply'] ?? $this->totalSupply;

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
