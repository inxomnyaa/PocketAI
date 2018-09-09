
<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _move_through_village implements BaseComponent
{
    protected $name = "minecraft:behavior.move_through_village";
    private $priority;private $speed_multiplier;private $only_at_night;

    public function __construct(string $name, $priority,$speed_multiplier,$only_at_night)
    {
        $this->priority = priority;$this->speed_multiplier = speed_multiplier;$this->only_at_night = only_at_night;
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
