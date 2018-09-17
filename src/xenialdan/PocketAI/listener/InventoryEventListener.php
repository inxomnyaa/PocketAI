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
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\filter\Filters;
use xenialdan\PocketAI\item\Lead;
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
                    return $this->onInventoryOpen($target, $player);
                }
                return true;
                #}
                break;
            case InteractPacket::ACTION_MOUSEOVER:
                $target = $player->getServer()->findEntity($packet->target);
                if (is_null($target)) {
                    return false;
                }
                if (!$target instanceof AIEntity) return false;
                return $this->onHover($target, $player);
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
                                return ($player->isSneaking() ? $this->onSneakRightClick($target, $player) : $this->onRightClick($target, $player));
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

    private function onSneakRightClick(Entity $target, Player $player)
    {//TODO move to AIEntity for better handling
        $itemInHand = $player->getInventory()->getItemInHand();
        $itemInHandId = $itemInHand->getId();
        switch ($itemInHandId) {
            default:
                return true; //cancel all item events - for now.
        }
        return false;
    }

    private function onRightClick(AIEntity $target, Player $player)
    {//TODO move to AIEntity for better handling
        switch ($player->getInventory()->getItemInHand()->getId()) {
            case Item::LEAD:
                {
                    /** @var Components $components */
                    $components = $target->getEntityProperties()->findComponents("minecraft:leashable");
                    if ($components->count() > 0) {
                        if ($target->isLeashed()) {
                            $target->setLeashedTo(null);
                        } else {
                            $target->setLeashedTo($player);
                        }
                    }
                    break;
                }
            default:
                {
                    /** @var Components $components */
                    $components = $target->getEntityProperties()->findComponents("minecraft:interact");
                    if ($components->count() > 0) {
                        /** @var _interact $component */
                        foreach ($components as $component) {
                            $on_interact_positive = true;
                            if (is_array($component->on_interact)) {//TODO event class
                                foreach ($component->on_interact as $key => $value) {
                                    if ($key === "filters") {//TODO move filter checks to seperate class
                                        $filters = new Filters($value);
                                        $on_interact_positive = $filters->test($target, $player);
                                        Loader::getInstance()->getLogger()->notice("All on_interact filters completed with result: " . ($on_interact_positive ? "YES" : "NO"));
                                    }
                                }
                            }
                            if ($on_interact_positive) {

                                $itemStackInHand = $player->getInventory()->getItemInHand();
                                /** @var Item|null $addItem */
                                $addItem = null;
                                try {
                                    $itemInHand = (clone $itemStackInHand)->pop();
                                } catch (\InvalidArgumentException $e) {
                                    $itemInHand = new Item(Item::AIR);
                                }
                                try {
                                    if (!is_null($component->use_item) && $component->use_item) {
                                        $itemStackInHand->pop();
                                    }
                                    if (!is_null($component->hurt_item) && $itemInHand instanceof Durable) {
                                        $itemInHand->applyDamage($component->hurt_item);
                                    }
                                    if (!is_null($component->play_sounds)) {
                                        foreach (explode(",", $component->play_sounds) as $sound) {//TODO find seperator - no multi-sounds in vanilla behaviours
                                            $pk = new LevelSoundEventPacket();
                                            $pk->sound = constant(get_class($pk) . "::SOUND_" . strtoupper($sound));
                                            $pk->position = $target->asVector3();
                                            $player->sendDataPacket($pk);
                                        }
                                    }
                                    if (!is_null($component->transform_to_item) && ($item = Item::fromString($component->transform_to_item)) instanceof Item) {
                                        $addItem = $item;
                                    }
                                } catch (\InvalidArgumentException $e) {
                                    //Logger: warning -> x component failed to succeed due to an error in parsing the json script in x aientity with x player
                                    return false;//Abort interaction to remain items even though the component data was invalid
                                }
                                if ($itemStackInHand->isNull()) {
                                    if (!is_null($addItem) && !$addItem->isNull()) {
                                        $player->getInventory()->setItemInHand($addItem);
                                    }
                                } else {
                                    if (!is_null($addItem) && !$addItem->isNull()) {
                                        $player->getInventory()->addItem($addItem);
                                    }
                                    $player->getInventory()->setItemInHand($itemStackInHand);
                                }
                                if (!$itemInHand->equals($itemStackInHand, true, true)) {
                                    $player->getInventory()->addItem($itemInHand);
                                }

                            }
                        }
                        return true;
                    }
                }
        }
        return false;
    }

    public function onInventoryOpen(InventoryHolder $inventoryHolder, Player $player)
    { //TODO other entities //TODO move to AIEntity for better handling
        if ($inventoryHolder instanceof AIEntity && !is_null($inventoryHolder->getInventory())) {
            var_dump($inventoryHolder->getInventory()->getName());
            var_dump($inventoryHolder->getInventory()->getNetworkType());
            $player->addWindow($inventoryHolder->getInventory());
            return true;
        }
        return false;
    }

    private function onHover(AIEntity $target, Player $player)
    {//TODO move to AIEntity for better handling
        /** @var Components $components */
        $components = $target->getEntityProperties()->findComponents("minecraft:interact");
        if ($components->count() > 0) {
            /** @var _interact $component */
            foreach ($components as $component) {//TODO filter & condition checks
                print_r($component);
                $player->sendTip($component->interact_text ?? "");//TODO remove debug
                $player->getDataPropertyManager()->setString(Entity::DATA_INTERACTIVE_TAG, $component->interact_text ?? "");
            }
            return true;
        }
        return false;
    }
}