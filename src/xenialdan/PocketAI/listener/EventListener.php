<?php

namespace xenialdan\PocketAI\listener;

use pocketmine\block\Fence;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\network\mcpe\protocol\PlayerInputPacket;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use xenialdan\PocketAI\entity\LeashKnot;
use xenialdan\PocketAI\entitytype\AIEntity;

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

    public function onInteract(PlayerInteractEvent $event)
    {
        switch ($event->getAction()) {
            case PlayerInteractEvent::RIGHT_CLICK_BLOCK:
                {
                    if (!$event->getBlock() instanceof Fence) return;
                    foreach ($event->getPlayer()->getLevel()->getEntities() as $entity) {
                        if (!$entity instanceof AIEntity) continue;
                        if ($entity->getDataPropertyManager()->getLong(AIEntity::DATA_LEAD_HOLDER_EID) === $event->getPlayer()->getId()) {
                            $knot = new LeashKnot($event->getPlayer()->getLevel(), LeashKnot::createBaseNBT($event->getBlock()->asVector3()->add(0.5, 0, 0.5)));
                            $event->getPlayer()->getLevel()->addEntity($knot);
                            $knot->spawnToAll();
                            print_r($knot->getId());
                            print_r($knot->getLevel()->getName());
                            print_r($entity->getDataPropertyManager()->getLong(AIEntity::DATA_LEAD_HOLDER_EID));
                            $entity->setLeashedTo($knot);
                            print_r($entity->getDataPropertyManager()->getLong(AIEntity::DATA_LEAD_HOLDER_EID));
                            $entity->getLevel()->broadcastLevelSoundEvent($event->getBlock(), LevelSoundEventPacket::SOUND_LEASHKNOT_PLACE);
                        }
                    }
                    break;
                }
        }
    }
}