
<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _raid_garden implements BaseComponent
{
    protected $name = "minecraft:behavior.raid_garden";
    private $priority;private $blocks;private $search_range;private $goal_radius;

    public function __construct(string $name, $priority,$blocks,$search_range,$goal_radius)
    {
        $this->priority = priority;$this->blocks = blocks;$this->search_range = search_range;$this->goal_radius = goal_radius;
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
