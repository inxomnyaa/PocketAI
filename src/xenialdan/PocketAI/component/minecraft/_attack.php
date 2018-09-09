<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _attack implements BaseComponent
{
    protected $name = "minecraft:attack";
    private $damage;
    private $effect_duration = 0.0;
    private $effect_name = "";

    /**
     * Defines an entity's melee attack and any additional effects on it.
     * _attack constructor.
     * @param $damage Range[a,b] Range of the random amount of damage the melee attack deals
     * @param float $effect_duration Duration in seconds of the status ailment applied to the damaged entity
     * @param string $effect_name Name of the status ailment to apply to an entity attacked by this entity's melee attack
     */
    public function __construct($damage, float $effect_duration = 0.0, string $effect_name = "")
    {
        $this->damage = $damage;
        $this->effect_duration = $effect_duration;
        $this->effect_name = $effect_name;
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
