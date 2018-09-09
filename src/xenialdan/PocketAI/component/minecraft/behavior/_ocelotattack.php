
<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _ocelotattack implements BaseComponent
{
    protected $name = "minecraft:behavior.ocelotattack";
    private $priority;private $walk_speed_multiplier;private $sprint_speed_multiplier;private $sneak_speed_multiplier;

    public function __construct(string $name, $priority,$walk_speed_multiplier,$sprint_speed_multiplier,$sneak_speed_multiplier)
    {
        $this->priority = priority;$this->walk_speed_multiplier = walk_speed_multiplier;$this->sprint_speed_multiplier = sprint_speed_multiplier;$this->sneak_speed_multiplier = sneak_speed_multiplier;
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
