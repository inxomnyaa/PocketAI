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
     * @throws \ReflectionException
     */
    public function onPrime(ExplosionPrimeEvent $event)
    {
        if (($entity = $event->getEntity()) instanceof AIEntity && !$event->isCancelled()) {
            /** @var AIEntity $entity */
            $ev = new AddonEvent($this->owner, $entity, "minecraft:on_prime");
            $ev->call();
            $event->setCancelled($ev->isCancelled());
        }
    }

    /**
     * Built-in Events
     * @param EntitySpawnEvent $event
     * @throws \ReflectionException
     */
    public function entitySpawned(EntitySpawnEvent $event)
    {
        /** @var AIEntity $entity */
        if (($entity = $event->getEntity()) instanceof AIEntity && $entity->ticksLived === 0) {
            $ev = new AddonEvent($this->owner, $entity, "minecraft:entity_spawned");
            $ev->call();
        }
    }

    public function onAddonEvent(AddonEvent $event)
    {
        $entityProperties = $event->getEntity()->getEntityProperties();
        if (is_null($entityProperties)) return;
        $data = $entityProperties->getEventData($event->getEvent());
        $event->execute($data);
    }
}