<?php

namespace xenialdan\PocketAI\inventory;

use pocketmine\entity\Entity;
use pocketmine\inventory\ContainerInventory;
use pocketmine\inventory\InventoryHolder;
use pocketmine\network\mcpe\protocol\types\WindowTypes;
use pocketmine\Player;

class AIEntityInventory extends ContainerInventory
{
    private $container_type;

    /**
     * AIEntityInventory constructor.
     * @param InventoryHolder $holder
     * @param array $items
     * @param null $size
     * @param null $title
     * @param string $container_type
     * @throws \Exception
     */
    public function __construct(InventoryHolder $holder, $items = [], $size = null, $title = null, $container_type = "inventory")
    {//TODO validate $container_type
        if ($holder instanceof Entity)
            parent::__construct($holder, $items, $size, $title);
        else throw new \Exception("InventoryHolder is no entity");
        $this->container_type = $container_type;
    }

    public function getName(): string
    {
        return ucfirst($this->container_type);
    }

    public function onOpen(Player $who): void
    {
        parent::onOpen($who);
        var_dump($this->getContents());
    }

    public function getDefaultSize(): int
    {
        return 1;
    }

    /**
     * Returns the Minecraft PE inventory type used to show the inventory window to clients.
     * @return int
     */
    public function getNetworkType(): int
    {
        $type = strtoupper($this->container_type);
        return defined(WindowTypes::class . "::" . $type) ? constant(WindowTypes::class . "::" . $type) : WindowTypes::INVENTORY;
    }
}