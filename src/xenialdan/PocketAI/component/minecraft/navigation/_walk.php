
<?php

namespace xenialdan\PocketAI\component\minecraft\navigation;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _walk implements BaseComponent
{
    protected $name = "minecraft:navigation.walk";
    private $can_float;private $can_pass_doors;private $can_open_doors;private $avoid_portals;

    public function __construct(string $name, $can_float,$can_pass_doors,$can_open_doors,$avoid_portals)
    {
        $this->can_float = can_float;$this->can_pass_doors = can_pass_doors;$this->can_open_doors = can_open_doors;$this->avoid_portals = avoid_portals;
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
