<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;
use xenialdan\PocketAI\event\CallableEvent;

class _ageable extends BaseComponent
{
    protected $name = "minecraft:ageable";
    /** @var float $duration Amount of time before the entity grows */
    public $duration = 1200.0;
    /** @var array $feedItems List of items that can be fed to the entity. Includes 'item' for the item name and 'growth' to define how much time it grows up by */
    public $feedItems;
    /** @var CallableEvent $grow_up Event to run when this entity grows up */
    public $grow_up;

    /**
     * Adds a timer for the entity to grow up. It can be accelerated by giving the entity the items it likes as defined by feedItems.
     * _ageable constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->duration = $values['duration'] ?? $this->duration;
        $this->feedItems = $values['feedItems'] ?? $this->feedItems;
        $this->grow_up = new CallableEvent($values['grow_up'] ?? []);
    }

    /**
     * Applies the changes to the mob
     * @param AIEntity|AIProjectile $entity
     */
    public function apply($entity): void
    {
    }

    /**
     * Removes the changes from the mob
     * @param AIEntity|AIProjectile $entity
     */
    public function remove($entity): void
    {
    }
}
