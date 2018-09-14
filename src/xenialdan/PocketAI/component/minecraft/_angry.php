<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _angry extends BaseComponent
{
    protected $name = "minecraft:angry";
    /** @var bool $broadcastAnger If true, other entities of the same entity definition within the broadcastRange will also become angry */
    public $broadcastAnger = false;
    /** @var int $broadcastRange Distance in blocks within which other entities of the same entity definition will become angry */
    public $broadcastRange = 20;
    /** @var string $calm_event Event to run after the number of seconds specified in duration expires (when the entity stops being 'angry') */
    public $calm_event;
    /** @var int $duration The amount of time in seconds that the entity will be angry */
    public $duration = 25;

    /**
     * Defines the entity's 'angry' state using a timer.
     * _angry constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->broadcastAnger = $values['broadcastAnger'] ?? $this->broadcastAnger;
        $this->broadcastRange = $values['broadcastRange'] ?? $this->broadcastRange;
        $this->calm_event = $values['calm_event'] ?? $this->calm_event;
        $this->duration = $values['duration'] ?? $this->duration;

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
