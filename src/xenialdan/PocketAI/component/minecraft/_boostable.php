<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _boostable extends BaseComponent
{
    protected $name = "minecraft:boostable";
    /** @var array $boost_items List of items that can be used to boost while riding this entity. Each item has the following properties:
     * ;Parameters
     *
     */
    public $boost_items;
    /** @var int $damage This is the damage that the item will take each time it is used */
    public $damage = 1;
    /** @var string $item Name of the item that can be used to boost */
    public $item;
    /** @var string $replaceItem The item used to boost will become this item once it is used up */
    public $replaceItem;
    /** @var int $duration Time in seconds for the boost */
    public $duration = 3;
    /** @var float $speed_multiplier Factor by which the entity's normal speed increases. E.g. 2.0 means go twice as fast */
    public $speed_multiplier = 1.0;


    /**
     * Defines the conditions and behavior of a rideable entity's boost
     * _boostable constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->boost_items = $values['boost_items'] ?? $this->boost_items;
        $this->damage = $values['damage'] ?? $this->damage;
        $this->item = $values['item'] ?? $this->item;
        $this->replaceItem = $values['replaceItem'] ?? $this->replaceItem;
        $this->duration = $values['duration'] ?? $this->duration;
        $this->speed_multiplier = $values['speed_multiplier'] ?? $this->speed_multiplier;

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
