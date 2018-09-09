
<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _beg implements BaseComponent
{
    protected $name = "minecraft:behavior.beg";
    private $priority;private $look_distance;private $look_time;private $items;

    public function __construct(string $name, $priority,$look_distance,$look_time,$items)
    {
        $this->priority = priority;$this->look_distance = look_distance;$this->look_time = look_time;$this->items = items;
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
