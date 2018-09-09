
<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _lookat implements BaseComponent
{
    protected $name = "minecraft:lookat";
    private $searchRadius;private $setTarget;private $look_cooldown;private $filters;

    public function __construct(string $name, $searchRadius,$setTarget,$look_cooldown,$filters)
    {
        $this->searchRadius = searchRadius;$this->setTarget = setTarget;$this->look_cooldown = look_cooldown;$this->filters = filters;
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
