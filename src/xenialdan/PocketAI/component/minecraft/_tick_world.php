<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _tick_world extends BaseComponent
{
    protected $name = "minecraft:tick_world";
    /** @var float $distance_to_players The distance at which the closest player has to be before this entity despawns. This option will be ignored if never_despawn is true. Min: 128 blocks. */
    public $distance_to_players = 128;
    /** @var bool $never_despawn If true, this entity will not despawn even if players are far away. If false, distance_to_players will be used to determine when to despawn. */
    public $never_despawn = true;
    /** @var int $radius The area around the entity to tick. Default: 2. Allowed range: 2-6. */
    public $radius = 2;

    /**
     * Defines if the entity ticks the world and the radius around it to tick.
     * _tick_world constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->distance_to_players = $values['distance_to_players'] ?? $this->distance_to_players;
        $this->never_despawn = $values['never_despawn'] ?? $this->never_despawn;
        $this->radius = $values['radius'] ?? $this->radius;

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
