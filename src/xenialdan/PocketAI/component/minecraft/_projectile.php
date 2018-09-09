
<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _projectile implements BaseComponent
{
    protected $name = "minecraft:projectile";
    private $onHit;private $power;private $gravity;private $angleoffset;private $hitSound;

    public function __construct(string $name, $onHit,$power,$gravity,$angleoffset,$hitSound)
    {
        $this->onHit = onHit;$this->power = power;$this->gravity = gravity;$this->angleoffset = angleoffset;$this->hitSound = hitSound;
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
