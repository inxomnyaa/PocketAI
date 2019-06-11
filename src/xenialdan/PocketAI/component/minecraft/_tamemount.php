<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;
use xenialdan\PocketAI\event\CallableEvent;

class _tamemount extends BaseComponent
{
    protected $name = "minecraft:tamemount";
    /** @var int $attemptTemperMod The amount the entity's temper will increase when mounted */
    public $attemptTemperMod = 5;
    /** @var mixed (JSON Object) $autoRejectItems The list of items that, if carried while interacting with the entity, will anger it
     * ;Parameters
     *
     */
    public $autoRejectItems;
    /** @var string $item Name of the item this entity likes and can be used to increase this entity's temper */
    public $item;
    /** @var mixed (JSON Object) $feedItems The list of items that can be used to increase the entity's temper and speed up the taming process
     * ;Parameters
     *
     */
    public $feedItems;
    /** @var float $temperMod The amount of temper this entity gains when fed this item */
    public $temperMod = 0.0;
    /** @var string $feed_text The text that shows in the feeding interact button */
    public $feed_text;
    /** @var int $maxTemper The maximum value for the entity's random starting temper */
    public $maxTemper = 100;
    /** @var int $minTemper The minimum value for the entity's random starting temper */
    public $minTemper;
    /** @var string $ride_text The text that shows in the riding interact button */
    public $ride_text;
    /** @var CallableEvent $tame_event Event that triggers when the entity becomes tamed */
    public $tame_event;

    /**
     * Allows the Entity to be tamed by mounting it.
     * _tamemount constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->attemptTemperMod = $values['attemptTemperMod'] ?? $this->attemptTemperMod;
        $this->autoRejectItems = $values['autoRejectItems'] ?? $this->autoRejectItems;
        $this->item = $values['item'] ?? $this->item;
        $this->feedItems = $values['feedItems'] ?? $this->feedItems;
        $this->temperMod = $values['temperMod'] ?? $this->temperMod;
        $this->feed_text = $values['feed_text'] ?? $this->feed_text;
        $this->maxTemper = $values['maxTemper'] ?? $this->maxTemper;
        $this->minTemper = $values['minTemper'] ?? $this->minTemper;
        $this->ride_text = $values['ride_text'] ?? $this->ride_text;
        $this->tame_event = new CallableEvent($values['tame_event'] ?? []);

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
