
<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _melee_attack implements BaseComponent
{
    protected $name = "minecraft:behavior.melee_attack";
    private $priority;private $speed_multiplier;private $track_target;

    public function __construct(string $name, $priority,$speed_multiplier,$track_target)
    {
        $this->priority = priority;$this->speed_multiplier = speed_multiplier;$this->track_target = track_target;
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
