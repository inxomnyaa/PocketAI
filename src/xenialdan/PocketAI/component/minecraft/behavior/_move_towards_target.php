
<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _move_towards_target implements BaseComponent
{
    protected $name = "minecraft:behavior.move_towards_target";
    private $priority;private $speed_multiplier;private $within_radius;

    public function __construct(string $name, $priority,$speed_multiplier,$within_radius)
    {
        $this->priority = priority;$this->speed_multiplier = speed_multiplier;$this->within_radius = within_radius;
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
