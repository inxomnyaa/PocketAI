<?php

namespace xenialdan\PocketAI\listener;

use pocketmine\entity\Entity;
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\inventory\InventoryHolder;
use pocketmine\network\mcpe\protocol\InteractPacket;
use pocketmine\network\mcpe\protocol\InventoryTransactionPacket;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use xenialdan\PocketAI\component\Components;
use xenialdan\PocketAI\component\minecraft\_interact;
use xenialdan\PocketAI\entitytype\AIEntity;

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

    private function onRightClick(Entity $target, Player $player)
    {//TODO move to AIEntity for better handling
        $itemInHand = $player->getInventory()->getItemInHand();
        $itemInHandId = $itemInHand->getId();
        switch ($itemInHandId) {
            default:
                return true; //cancel all item events - for now.
        }
        return false;
    }

    private function onSneakRightClick(AIEntity $target, Player $player)
    {//TODO move to AIEntity for better handling
        /** @var Components $components */
        $components = $target->getEntityProperties()->findComponents("minecraft:interact");
        if($components->count() > 0){
            /** @var _interact $component */
            foreach ($components as $component){//TODO filter & condition checks
                $player->sendTip(print_r($component,true));//TODO remove debug
                if(is_array($component->on_interact)){
                    foreach ($component->on_interact as $key => $value){
                        if($key === "filters"){//TODO move filter checks to seperate class
                            foreach ($value as $k => $v){
                                if($k === "all_of"){
                                    foreach ($v as $testdata){
                                        $class = "xenialdan\\PocketAI\\component\\_" . array_slice($testdata, array_search("test", $testdata), 1)[0];
                                        unset($testdata[array_search("test", $testdata)]);
                                        if(class_exists($class)){
                                            $testclass = new $class($testdata);
                                            print_r($testclass);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return true;
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
        if($components->count() > 0){
            /** @var _interact $component */
            foreach ($components as $component){//TODO filter & condition checks
                print_r($component);
                $player->sendTip($component->interact_text??"");//TODO remove debug
                $player->getDataPropertyManager()->setString(Entity::DATA_INTERACTIVE_TAG, $component->interact_text??"");
            }
            return true;
        }
        return false;
    }
}