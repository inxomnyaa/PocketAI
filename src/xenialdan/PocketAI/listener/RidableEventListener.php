<?php

namespace xenialdan\PocketAI\listener;

use pocketmine\entity\Entity;
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\item\ItemIds;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\InteractPacket;
use pocketmine\network\mcpe\protocol\InventoryTransactionPacket;
use pocketmine\network\mcpe\protocol\MoveEntityPacket;
use pocketmine\network\mcpe\protocol\RiderJumpPacket;
use pocketmine\network\mcpe\protocol\SetEntityMotionPacket;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\interfaces\Rideable;
use xenialdan\PocketAI\Loader;

/**
 * Class EventListener
 * @package xenialdan\PocketAI
 * Listens for all events regarding ridable entities
 */
class RidableEventListener implements Listener{
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
			case RiderJumpPacket::NETWORK_ID: {
				/** @var RiderJumpPacket $packet */
				$event->setCancelled($this->handleRiderJump($packet, $player));
				break;
			}
			case MoveEntityPacket::NETWORK_ID: {
				/** @var MoveEntityPacket $packet */
				$event->setCancelled($this->handleMoveEntity($packet, $player));
				break;
			}
			case SetEntityMotionPacket::NETWORK_ID: { // called for player
				/** @var SetEntityMotionPacket $packet */
				$event->setCancelled($this->handleSetEntityMotion($packet, $player));
				break;
			}
			case InventoryTransactionPacket::NETWORK_ID: {
				/** @var InventoryTransactionPacket $packet */
				$event->setCancelled($this->handleInventoryTransaction($packet, $player));
				break;
			}
			case InteractPacket::NETWORK_ID: {
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
	public function handleInteract(InteractPacket $packet, Player $player): bool{
		switch ($packet->action){
			case InteractPacket::ACTION_LEAVE_VEHICLE:
				if (Loader::isRiding($player)){
					Loader::setEntityLink($player->getServer()->findEntity($packet->target, $player->getLevel()), $player, 0);
					return true;
				}
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
	public function handleInventoryTransaction(InventoryTransactionPacket $packet, Player $player): bool{
		switch ($packet->transactionType){
			case InventoryTransactionPacket::TYPE_USE_ITEM_ON_ENTITY: {
				$type = $packet->trData->actionType;
				switch ($type){
					case InventoryTransactionPacket::USE_ITEM_ON_ENTITY_ACTION_INTERACT: {
						$target = $player->getLevel()->getEntity($packet->trData->entityRuntimeId);
						if (is_null($target)){
							return false;
						}
						if (!$target instanceof AIEntity) return false;
						return ($player->isSneaking() ? false : $this->onRightClick($target, $player));
					}
				}
				break;
			}
			default: {
			}
		}

		return false;
	}

	/**
	 * @param MoveEntityPacket $packet
	 * @param Player $player
	 * @return bool
	 */
	private function handleMoveEntity(MoveEntityPacket $packet, Player $player){
		$target = $player->getServer()->findEntity($packet->entityRuntimeId, $player->getLevel());
		if (is_null($target)){
			return false;
		}
		if (!$target instanceof AIEntity && !$target instanceof Rideable) return false;

		$target->move(-($target->x - $packet->position->x), -($target->y - $packet->position->y), -($target->z - $packet->position->z));
		$target->setRotation($packet->yaw, $packet->pitch);
		$target->onGround = $packet->onGround;
		return true;
	}

	/**
	 * @param SetEntityMotionPacket $packet
	 * @param Player $player
	 * @return bool
	 */
	private function handleSetEntityMotion(SetEntityMotionPacket $packet, Player $player){
		if (($packet->motion->equals(new Vector3()))) return true; //remove spammy empty ones
		$target = $player->getServer()->findEntity($packet->entityRuntimeId, $player->getLevel());
		if (is_null($target)){
			return false;
		}
		if (!$target instanceof Player && !Loader::isRiding($target)) return false;

		return $target->setMotion($packet->motion);
	}

	/**
	 * @param RiderJumpPacket $packet
	 * @param Player $player
	 * @return bool
	 */
	public function handleRiderJump(RiderJumpPacket $packet, Player $player): bool{
		var_dump($packet);
		return true; //TODO: find entity, let it jump
	}

	private function onRightClick(Entity $target, Player $player){
		$itemInHand = $player->getInventory()->getItemInHand();
		$itemInHandId = $itemInHand->getId();
		switch ($itemInHandId){
			case ItemIds::AIR: {
				if ($target instanceof Rideable){
					Loader::setEntityLink($target, $player);
					return true;
				}
			}
		}
		return false;
	}
}