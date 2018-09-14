<?php

namespace xenialdan\PocketAI\listener;

use pocketmine\event\entity\EntitySpawnEvent;
use pocketmine\event\entity\ExplosionPrimeEvent;
use pocketmine\event\Listener;
use pocketmine\plugin\Plugin;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\event\AddonEvent;

/**
 * Class AddonEventListener
 * @package xenialdan\PMCMDUnregisterer
 * Listens for all addon-related events and calls AddonEvents
 */
class AddonEventListener implements Listener
{
    public $owner;

    /**
     * EventListener constructor.
     * @param Plugin $plugin
     */
    public function __construct(Plugin $plugin)
    {
        $this->owner = $plugin;
    }

    /**
     * Built-in Events
     * @param ExplosionPrimeEvent $event
     */
    public function onPrime(ExplosionPrimeEvent $event)
    {
        if (($entity = $event->getEntity()) instanceof AIEntity && !$event->isCancelled()) {
            /** @var AIEntity $entity */
            $this->owner->getServer()->getPluginManager()->callEvent($ev = new AddonEvent($this->owner, $entity, "minecraft:on_prime"));
            $event->setCancelled($ev->isCancelled());
        }
    }

    /**
     * Built-in Events
     * @param EntitySpawnEvent $event
     */
    public function entitySpawned(EntitySpawnEvent $event)
    {
        if (($entity = $event->getEntity()) instanceof AIEntity) {
            /** @var AIEntity $entity */
            $this->owner->getServer()->getPluginManager()->callEvent($ev = new AddonEvent($this->owner, $entity, "minecraft:entity_spawned"));
        }
    }

    public function onAddonEvent(AddonEvent $event)
    {
        $data = $event->getEntity()->getEntityProperties()->getEvent($event->getEvent());
        $event->execute($data);
    }
}