<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _find_mount extends BaseComponent
{
    protected $name = "minecraft:behavior.find_mount";
    /** @var bool $avoid_water If true, the mob will not go into water blocks when going towards a mount */
    public $avoid_water = false;
    /** @var float $mount_distance This is the distance the mob needs to be, in blocks, from the desired mount to mount it. If the value is below 0, the mob will use its default attack distance */
    public $mount_distance = -1.0;
    /** @var int $start_delay Time the mob will wait before starting to move towards the mount */
    public $start_delay;
    /** @var bool $target_needed If true, the mob will only look for a mount if it has a target */
    public $target_needed = false;
    /** @var float $within_radius Distance in blocks within which the mob will look for a mount */
    public $within_radius = 0.0;

    /**
     * Allows the mob to look around for another mob to ride atop it.
     * _find_mount constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->avoid_water = $values['avoid_water'] ?? $this->avoid_water;
        $this->mount_distance = $values['mount_distance'] ?? $this->mount_distance;
        $this->start_delay = $values['start_delay'] ?? $this->start_delay;
        $this->target_needed = $values['target_needed'] ?? $this->target_needed;
        $this->within_radius = $values['within_radius'] ?? $this->within_radius;

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
