<?php

declare(strict_types=1);

namespace xenialdan\PocketAI\item;

use pocketmine\item\Item;

class Lead extends Item
{

    public function __construct(int $meta = 0)
    {
        parent::__construct(self::LEAD, $meta, "Lead");
    }
}