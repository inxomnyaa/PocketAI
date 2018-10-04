<?php


namespace xenialdan\astar3d;


use pocketmine\entity\Entity;
use pocketmine\level\Position;
use pocketmine\math\Vector3;

class Obstacle extends Position
{
    /** @var GameObject|Entity */
    public $gameObject;
    /** @var MeshRenderer */
    public $renderer;
    /** @var Vector3 */
    public $oldPosition;
    /** @var Vector3 */
    public $oldEulerAngles;
    /* * @var List<Node> */
    /** @var \SplQueue Node[] */
    public $affectedNodes;

    /**
     * Obstacle constructor.
     * @param GameObject|Entity $gameObject
     * @param $renderer //TODO REMOVE
     * @param Vector3 $oldPosition
     * @param Vector3 $oldEulerAngles
     */
    public function __construct($gameObject, $renderer, Vector3 $oldPosition, Vector3 $oldEulerAngles)
    {
        parent::__construct();
        $this->gameObject = $gameObject;
        $this->renderer = $gameObject->getBoundingBox();
        $this->oldPosition = $oldPosition;
        $this->oldEulerAngles = $oldEulerAngles;
        $this->affectedNodes = new \SplQueue();
    }
}