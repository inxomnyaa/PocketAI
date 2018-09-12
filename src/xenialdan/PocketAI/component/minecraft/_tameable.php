<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _tameable extends BaseComponent
{
    protected $name = "minecraft:tameable";
    /** @var float $probability The chance of taming the entity with each item use between 0.0 and 1.0, where 1.0 is 100% */
    public $probability = 1.0;
    /** @var array $tameItems The list of items that can be used to tame this entity */
    public $tameItems;
    /** @var string $tame_event Event to run when this entity becomes tamed */
    public $tame_event;


    /**
     * Defines the rules for a mob to be tamed by the player.
     * _tameable constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->probability = $values['probability'] ?? $this->probability;
        $this->tameItems = $values['tameItems'] ?? $this->tameItems;
        $this->tame_event = $values['tame_event'] ?? $this->tame_event;

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
