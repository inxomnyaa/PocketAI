<?php


namespace xenialdan\astar3d;


use pocketmine\math\Vector3;

class Ray
{
    /** @var Vector3 */
    public $from;
    /** @var Vector3 */
    public $to;

    /**
     * Ray constructor.
     * @param Vector3 $from
     * @param Vector3 $to
     */
    public function __construct(Vector3 $from, Vector3 $to)
    {
        $this->from = $from;
        $this->to = $to;
    }


}