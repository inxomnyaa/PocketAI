<?php


namespace xenialdan\astar3d;


use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;
use pocketmine\utils\MainLogger;

class Pathfinder
{

    /** @var Grid */
    public $grid;
    /** @var PathRequestManager */
    public $requestManager;

    public function StartFindingPath(Vector3 $start, Vector3 $end): void
    {
        //StartCoroutine(FindPath($start, $end));
        $this->FindPath($start, $end);
    }

    private function FindPath(Vector3 $startPos, Vector3 $targetPos): \Generator
    {
        /** @var Vector3[] */
        $waypoints = [];
        /** @var bool */
        $wasSuccessful = false;

        /** @var Node $startNode */
        $startNode = $this->grid->NodeFromWorldPoint($startPos);
        /** @var Node $targetNode */
        $targetNode = $this->grid->NodeFromWorldPoint($targetPos);

        if ($startNode->walkable && $targetNode->walkable) {
            $openSet = new \SplQueue();
            $closedSet = new \SplQueue();

            $openSet->add($openSet->count(), $startNode);//TODO check if count + 1

            while ($openSet->count() > 0) {
                /** @var Node $currentNode */
                $currentNode = $openSet->shift();
                $closedSet->add($openSet->count(), $currentNode);//TODO check if count + 1

                if ($currentNode === $targetNode) {
                    $wasSuccessful = true;
                    break;
                }

                //foreach (Node $neighbor in $grid.GetNeighbors($currentNode)) {
                /** @var Node $neighbor */
                foreach ($this->grid->GetNeighbors($currentNode) as $neighbor) {
                    if (!$neighbor->walkable || $this->Contains($closedSet, $neighbor)) continue;

                    /** @var int $newMoveCostToNeighbor */
                    $newMoveCostToNeighbor = $currentNode->gCost + $this->GetDistance($currentNode, $neighbor) + $neighbor->movementPenalty;

                    if ($newMoveCostToNeighbor < $neighbor->gCost || !$this->Contains($openSet, $neighbor)) {
                        $neighbor->gCost = $newMoveCostToNeighbor;
                        $neighbor->hCost = $this->GetDistance($neighbor, $targetNode);
                        $neighbor->parentNode = $currentNode;

                        if (!$this->Contains($openSet, $neighbor)) {
                            $openSet->add($openSet->count(), $neighbor);//TODO check if count + 1
                        } else {
                            $openSet->add(array_search($neighbor, clone $openSet), $neighbor);//TODO check if key + 1
                        }
                    }
                }
            }
        } else {
            /** @var string */
            $msga = $startNode->walkable ? "" : "Start position is unwalkable. Unable to generate path. ";
            /** @var string */
            $msgb = $targetNode->walkable ? "" : "Target position is unwalkable. Unable to generate path";
            if (!empty($msga) || !empty($msgb)) MainLogger::getLogger()->Log($msga . $msgb);
        }
        yield;
        if ($wasSuccessful) {
            $waypoints = $this->RetracePath($startNode, $targetNode);
        }
        $this->requestManager->FinishedProcessingPath($waypoints, $wasSuccessful);
    }

    /**
     * @param Node $startNode
     * @param Node $endNode
     * @return Vector3[]
     */
    private function RetracePath(Node $startNode, Node $endNode)
    {
        //List<Node> $path = new List<Node>();
        $path = new \SplQueue();
        /** @var Node $currentNode */
        $currentNode = $endNode;

        while ($currentNode !== $startNode) {
            $path->add($path->count(), $currentNode->parentNode);//TODO check if count + 1
            $currentNode = $currentNode->parentNode;
        }
        $simplePath = $this->SimplifyPath($path); //Vector3[]
        $path = array_reverse($path);
        $simplePath = array_reverse($simplePath);

        $this->grid->path = $path;
        return $simplePath;
    }

    /**
     * @param \SplQueue $path
     * @return Vector3[]
     */
    private function SimplifyPath(\SplQueue $path)
    { //Apply smoothing here
        /** @var \SplQueue $wayPoints */
        $wayPoints = new \SplQueue();
        /** @var Vector3 $directionOld */
        $directionOld = new Vector3();

        for ($i = 1; $i < $path->count(); $i++) {
            /** @var Node $pathMinusOne */
            $pathMinusOne = $path[$i - 1];
            /** @var Node $pathCurrent */
            $pathCurrent = $path[$i];
            /** @var Vector3 $directionNew */
            $directionNew = $pathMinusOne->gridPosition->subtract($pathCurrent->gridPosition);
            if ($directionNew !== $directionOld) {
                $wayPoints->add($wayPoints->count(), $pathCurrent->worldPosition);//TODO check if count + 1
            }
            $directionOld = $directionNew;
        }

        return iterator_to_array($wayPoints);
    }


    /**
     * @param Node $from
     * @param Node $to
     * @return int
     */
    private function GetDistance(Node $from, Node $to): int
    { //On XZ Plane
        /** @var int $dstX */
        $dstX = (int)abs($from->gridPosition->x - $to->gridPosition->x);
        /** @var int $dstZ */
        $dstZ = (int)abs($from->gridPosition->z - $to->gridPosition->z);

        if ($dstX > $dstZ) return 14 * $dstZ + 10 * ($dstX - $dstZ);
        else return 14 * $dstX + 10 * ($dstZ - $dstX);
    }
}