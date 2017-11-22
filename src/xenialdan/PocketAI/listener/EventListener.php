<?php

namespace xenialdan\PocketAI\listener;

use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\PlayerInputPacket;
use pocketmine\plugin\Plugin;

/**
 * Class EventListener
 * @package xenialdan\PocketAI
 * Listens for all normal events
 */
class EventListener implements Listener{
	public $owner;

	/**
	 * EventListener constructor.
	 * @param Plugin $plugin
	 */
	public function __construct(Plugin $plugin){
		$this->owner = $plugin;
	}

	public function onDataPacket(DataPacketReceiveEvent $event){
		$player = $event->getPlayer();
		$packet = $event->getPacket();
		switch ($packet::NETWORK_ID){
			case PlayerInputPacket::NETWORK_ID: { //REMOVES PACKET SPAM
				/** @var PlayerInputPacket $packet */
				$event->setCancelled(true);
				break;
			}
		}
	}
}