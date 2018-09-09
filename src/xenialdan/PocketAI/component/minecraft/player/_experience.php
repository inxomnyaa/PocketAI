
<?php

namespace xenialdan\PocketAI\component\minecraft\player;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _experience implements BaseComponent
{
    protected $name = "minecraft:player.experience";
    private $value;private $max;

    public function __construct(string $name, $value,$max)
    {
        $this->value = value;$this->max = max;
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
