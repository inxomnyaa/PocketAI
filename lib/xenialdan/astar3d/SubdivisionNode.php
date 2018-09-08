<?php


namespace xenialdan\astar3d;


use pocketmine\math\Vector3;

class SubdivisionNode
{
    /** @var Vector3 */
    public $position;
    /** @var int[] */
    public $startStopX; //Start and stop grid indices on X axis
    /** @var int[] */
    public $startStopY; //Start and stop grid indices on Y axis
    /** @var int[] */
    public $startStopZ; //Start and stop grid indices on Z axis

    /**
     * SubdivisionNode constructor.
     * @param Vector3 $position
     * @param int[] $startStopX
     * @param int[] $startStopY
     * @param int[] $startStopZ
     */
    public function __construct(Vector3 $position, array $startStopX, array $startStopY, array $startStopZ)
    {
        $this->position = $position;
        $this->startStopX = $startStopX;
        $this->startStopY = $startStopY;
        $this->startStopZ = $startStopZ;
    }
}