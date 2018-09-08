<?php

namespace xenialdan\astar3d;

use pocketmine\math\Vector3;

class Node
{
    /** @var bool */
    public $walkable;
    /** @var Vector3 */
    public $worldPosition;
    /** @var Vector3 */
    public $gridPosition;
    /** @var int */
    public $movementPenalty;

    /** @var int */
    public $gCost;
    /** @var int */
    public $hCost;
    /** @var Node */
    public $parentNode;
    /** @var int */
    private $heapIndex;

    /**
     * Node constructor.
     * @param bool $walkable
     * @param Vector3 $worldPosition
     * @param Vector3 $gridPosition
     * @param int $movementPenalty
     */
    public function __construct(bool $walkable, Vector3 $worldPosition, Vector3 $gridPosition, int $movementPenalty)
    {
        $this->walkable = $walkable;
        $this->worldPosition = $worldPosition;
        $this->gridPosition = $gridPosition;
        $this->movementPenalty = $movementPenalty;
    }

    public function UpdateWalkable(bool $walkable): void
    {
        $this->walkable = $walkable;
    }

    public function getFCost(): int
    {
        return $this->gCost + $this->hCost;
    }

    public function getHeapIndex(): int
    {
        return $this->heapIndex;
    }

    public function setHeapIndex(int $value): void
    {
        $this->heapIndex = $value;
    }

}
