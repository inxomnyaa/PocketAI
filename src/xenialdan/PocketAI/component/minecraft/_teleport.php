
<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _teleport implements BaseComponent
{
    protected $name = "minecraft:teleport";
    private $randomTeleports;private $maxRandomTeleportTime;private $randomTeleportCube;private $targetDistance;private $target_teleport_chance;private $lightTeleportChance;

    public function __construct(string $name, $randomTeleports,$maxRandomTeleportTime,$randomTeleportCube,$targetDistance,$target_teleport_chance,$lightTeleportChance)
    {
        $this->randomTeleports = randomTeleports;$this->maxRandomTeleportTime = maxRandomTeleportTime;$this->randomTeleportCube = randomTeleportCube;$this->targetDistance = targetDistance;$this->target_teleport_chance = target_teleport_chance;$this->lightTeleportChance = lightTeleportChance;
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
