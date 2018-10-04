<?php

namespace xenialdan\PocketAI\component\minecraft\behavior;

use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _send_event extends BehaviourComponent
{
    protected $name = "minecraft:behavior.send_event";
    /** @var float $cast_duration Time in seconds for the entire event sending process */
    public $cast_duration;
    /** @var array $sequence List of events to send
     * ;Parameters of each event
     *
     */
    public $sequence;
    /** @var float $base_delay Amount of time in seconds before starting this step */
    public $base_delay = 0.0;
    /** @var string $event The event to send to the entity */
    public $event;
    /** @var string $sound_event The sound event to play when this step happens */
    public $sound_event;

    /**
     * Allows the mob to send an event to another mob.
     * _send_event constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->cast_duration = $values['cast_duration'] ?? $this->cast_duration;
        $this->sequence = $values['sequence'] ?? $this->sequence;
        $this->base_delay = $values['base_delay'] ?? $this->base_delay;
        $this->event = $values['event'] ?? $this->event;
        $this->sound_event = $values['sound_event'] ?? $this->sound_event;

        parent::__construct($values);
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

    public function tick(int $tickDiff)
    {
        // TODO: Implement tick() method.
    }
}
