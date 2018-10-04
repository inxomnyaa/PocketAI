<?php

namespace xenialdan\PocketAI\listener;

use pocketmine\entity\Entity;
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\inventory\InventoryHolder;
use pocketmine\item\Durable;
use pocketmine\item\Item;
use pocketmine\network\mcpe\protocol\InteractPacket;
use pocketmine\network\mcpe\protocol\InventoryTransactionPacket;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use xenialdan\PocketAI\component\Components;
use xenialdan\PocketAI\component\minecraft\_interact;
use xenialdan\PocketAI\entity\LeashKnot;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\filter\Filters;
use xenialdan\PocketAI\Loader;

/**
 * Class EventListener
 * @package xenialdan\PMCMDUnregisterer
 * Listens for all events regarding inventory
 */
class InventoryEventListener implements Listener
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

    public function onDataPacket(DataPacketReceiveEvent $event)
    {
        $player = $event->getPlayer();
        $packet = $event->getPacket();
        switch ($packet::NETWORK_ID) {
            case InventoryTransactionPacket::NETWORK_ID:
                {
                    /** @var InventoryTransactionPacket $packet */
                    $event->setCancelled($this->handleInventoryTransaction($packet, $player));
                    break;
                }
            case InteractPacket::NETWORK_ID:
                {
                    /** @var InteractPacket $packet */
                    $event->setCancelled($this->handleInteract($packet, $player));
                    break;
                }
        }
    }

    /**
     * Don't expect much from this handler. Most of it is roughly hacked and duct-taped together.
     *
     * @param InteractPacket $packet
     * @param Player $player
     * @return bool
     */
    public function handleInteract(InteractPacket $packet, Player $player): bool
    {
        switch ($packet->action) {
            case InteractPacket::ACTION_OPEN_INVENTORY:
                /*if (Loader::isRiding($player)){*/
                $target = $player->getServer()->findEntity($packet->target);
                if (is_null($target)) {
                    return false;
                }
                if (!$target instanceof AIEntity) return false;
                if ($target instanceof InventoryHolder/* && $target instanceof Tamable && $target->isTamed()*/) {
                    return $target->onInventoryOpen($target, $player);
                }
                return true;
                #}
                break;
            case InteractPacket::ACTION_MOUSEOVER://TODO fix slot change
                $target = $player->getServer()->findEntity($packet->target);
                if (is_null($target)) {
                    return false;
                }
                if (!$target instanceof AIEntity) return false;
                return $target->onHover($target, $player);
                break;
        }

        return false;
    }

    /**
     * Don't expect much from this handler. Most of it is roughly hacked and duct-taped together.
     *
     * @param InventoryTransactionPacket $packet
     * @param Player $player
     * @return bool
     */
    public function handleInventoryTransaction(InventoryTransactionPacket $packet, Player $player): bool
    {
        switch ($packet->transactionType) {
            case InventoryTransactionPacket::TYPE_USE_ITEM_ON_ENTITY:
                {
                    $type = $packet->trData->actionType;
                    switch ($type) {
                        case InventoryTransactionPacket::USE_ITEM_ON_ENTITY_ACTION_INTERACT:
                            {
                                $target = $player->getLevel()->getEntity($packet->trData->entityRuntimeId);
                                if (is_null($target)) {
                                    return false;
                                }
                                if (!$target instanceof AIEntity) return false;
                                return $target->onRightClick($player);
                            }
                    }
                    break;
                }
            default:
                {
                }
        }

        return false;
    }
}