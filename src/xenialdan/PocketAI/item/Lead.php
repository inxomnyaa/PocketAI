<?php

declare(strict_types=1);

namespace xenialdan\PocketAI\item;

use pocketmine\block\Block;
use pocketmine\block\Fence;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\Player;

class Lead extends Item
{

    public function __construct(int $meta = 0)
    {
        parent::__construct(self::LEAD, $meta, "Lead");
    }

    public function onActivate(Player $player, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector): bool
    {
        if($blockClicked instanceof Fence){
            //TODO spawn LeashKnot, leash entity
            return true;
        }
        return false;
    }
}