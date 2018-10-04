<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _ocelotattack extends BehaviourComponent
{
    protected $name = "minecraft:behavior.ocelotattack";
    /** @var float $sneak_speed_multiplier Multiplier for the sneaking speed. 1.0 means the ocelot will move at the speed it normally sneaks */
    public $sneak_speed_multiplier = 1.0;
    /** @var float $sprint_speed_multiplier Multiplier for the running speed of this mob while using this attack */
    public $sprint_speed_multiplier = 1.0;
    /** @var float $walk_speed_multiplier Multiplier for the walking speed while using this attack */
    public $walk_speed_multiplier = 1.0;

    /**
     * Can only be used by the Ocelot. Allows it to perform the sneak and pounce attack.
     * _ocelotattack constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->sneak_speed_multiplier = $values['sneak_speed_multiplier'] ?? $this->sneak_speed_multiplier;
        $this->sprint_speed_multiplier = $values['sprint_speed_multiplier'] ?? $this->sprint_speed_multiplier;
        $this->walk_speed_multiplier = $values['walk_speed_multiplier'] ?? $this->walk_speed_multiplier;

        parent::__construct($values);
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

    public function tick(int $tickDiff)
    {
        // TODO: Implement tick() method.
    }
}
