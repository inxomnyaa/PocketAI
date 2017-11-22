<?php

namespace xenialdan\PocketAI\inventory;

use pocketmine\inventory\ContainerInventory;
use pocketmine\network\mcpe\protocol\types\WindowTypes;

class HorseInventory extends ContainerInventory{

	public function getName(): string{
		return "Horse Inventory";
	}

	public function getDefaultSize(): int{
		return 1;
	}

	/**
	 * Returns the Minecraft PE inventory type used to show the inventory window to clients.
	 * @return int
	 */
	public function getNetworkType(): int{
		return WindowTypes::HORSE;
	}
}