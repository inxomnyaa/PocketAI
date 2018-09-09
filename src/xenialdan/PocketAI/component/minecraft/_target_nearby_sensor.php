
<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _target_nearby_sensor implements BaseComponent
{
    protected $name = "minecraft:target_nearby_sensor";
    private $inside_range;private $outside_range;private $on_inside_range;

    public function __construct(string $name, $inside_range,$outside_range,$on_inside_range)
    {
        $this->inside_range = inside_range;$this->outside_range = outside_range;$this->on_inside_range = on_inside_range;
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
