<?php

namespace xenialdan\PocketAI\listener;

use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\PlayerInputPacket;
use pocketmine\Player;
use pocketmine\plugin\Plugin;

/**
 * Class EventListener
 * @package xenialdan\PMCMDUnregisterer
 * Listens for all normal events
 */
class EventListener implements Listener
{
    public $owner;
    /** @var Player */
    public $player;

    /**
     * EventListener constructor.
     * @param Plugin $plugin
     */
    public function __construct(Plugin $plugin)
    {
        $this->owner = $plugin;
    }

    public function onDataPacket(DataPacketReceiveEvent $event)
    {
        $this->player = $event->getPlayer();
        $packet = $event->getPacket();
        switch ($packet::NETWORK_ID) {
            case PlayerInputPacket::NETWORK_ID:
                { //REMOVES PACKET SPAM
                    /** @var PlayerInputPacket $packet */
                    $event->setCancelled(true);
                    break;
                }
        }
    }
}