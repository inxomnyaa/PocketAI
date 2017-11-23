<?php

namespace xenialdan\PocketAI\listener;

use pocketmine\event\entity\EntitySpawnEvent;
use pocketmine\event\entity\ExplosionPrimeEvent;
use pocketmine\event\Listener;
use pocketmine\plugin\Plugin;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\events\AddonEvent;

/**
 * Class AddonEventListener
 * @package xenialdan\PocketAI
 * Listens for all addon-related events and calls AddonEvents
 */
class AddonEventListener implements Listener{
	public $owner;

	/**
	 * EventListener constructor.
	 * @param Plugin $plugin
	 */
	public function __construct(Plugin $plugin){
		$this->owner = $plugin;
	}

	/**
	 * Built-in Events
	 * @param ExplosionPrimeEvent $event
	 */
	public function onPrime(ExplosionPrimeEvent $event){
		if (($entity = $event->getEntity()) instanceof AIEntity){
			$this->owner->getServer()->getPluginManager()->callEvent($ev = new AddonEvent($this->owner, $entity, "minecraft:on_prime"));
			$event->setCancelled($ev->isCancelled());
		}
	}

	/**
	 * Built-in Events
	 * @param EntitySpawnEvent $event
	 */
	public function entitySpawned(EntitySpawnEvent $event){
		if (($entity = $event->getEntity()) instanceof AIEntity){
			$this->owner->getServer()->getPluginManager()->callEvent($ev = new AddonEvent($this->owner, $entity, "minecraft:entity_spawned"));
		}
	}

	public function onAddonEvent(AddonEvent $event){
		switch ($event->getEvent()){
			case "minecraft:entity_spawned": {//TODO move all handling / getting / calling into EntityProperties
				$entityProperties = $event->getEntity()->getEntityProperties();
				$behaviours = $entityProperties->getBehaviours();
				if (!is_null($behaviours["minecraft:entity"]["events"][$event->getEvent()] ?? null)){
					$entityProperties->applyEvent($behaviours["minecraft:entity"]["events"][$event->getEvent()]);
				}
			}
		}
	}
}