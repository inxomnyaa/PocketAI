
<?php

namespace xenialdan\PocketAI\component\minecraft\navigation;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _climb implements BaseComponent
{
    protected $name = "minecraft:navigation.climb";
    private $can_float;

    public function __construct(string $name, $can_float)
    {
        $this->can_float = can_float;
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
