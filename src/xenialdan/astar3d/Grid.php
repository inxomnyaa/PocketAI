<?php


namespace xenialdan\astar3d;


use pocketmine\entity\object\ExperienceOrb;
use pocketmine\entity\object\FallingBlock;
use pocketmine\entity\object\ItemEntity;
use pocketmine\entity\object\Painting;
use pocketmine\entity\object\PrimedTNT;
use pocketmine\entity\projectile\Projectile;
use pocketmine\level\Level;
use pocketmine\math\RayTraceResult;
use pocketmine\math\Vector3;
use pocketmine\Server;
use pocketmine\utils\MainLogger;

class Grid
{

    const foDesc = "When set to false, the grid will accommodate for obstacles added and removed at runtime. Note that this is expensive";
    const wrDesc = "An array containing walkable regions. Penalty gives a region less preference of walking";
    const unDesc = "Layers where path cannot be";
    const nrDesc = "Size of each node in grid. Beware, smaller values adversely affect performance when updating surface";
    const upDesc = "Whether the grid should be updated to accommodate dynamic obstacles";
    const baDesc = "This is the surface to build the grid on. Must have MeshRenderer. Take note, this solution only works with upward-facing surfaces thus there is no normal compensation.";
    const sdDesc = "Sweep Testing performs an O(n)^3 operation by resolving the surface for nodes on all 3 axes. Subdivision Testing greatly speeds up grid creation by splitting grid creation into two passes: subdivision using a large node radius, then grid creation based on the subdivision grid. This greatly reduces the number of iterations used for grid creation. Use Benchmark mode for debugging the performance difference between Sweep Testing and Subdivision Testing";

    /** @var GameObject */
    public $Base;
    //Setup Parameters
    /** @var float */
    public $nodeRadius = 0.3;
    /** @var TestingMode */
    public $testingMode;
    //public bool performSubdivisionTesting;
    /* * @var SurfaceType[] */
    /** @var [] */
    public $walkableRegions;
    /* * @var LayerMask  */
    public $unwalkableMask;
    //Update Parameters
    /** @var bool */
    public $updateGrid; //optimize by spreading over number of frames //Use heap and do unwalkable testing
    /** @var bool */
    public $fixedObstaclesCount;
    //Debug
    /** @var GridDisplayMode */
    public $gridDisplayMode;
    //public bool benchmarkMode;

    /** @var Node [,,]
     * This is a list/array/dictionary containing x y z as keys
     */
    //public $grid;
    /** @var \SplQueue */
    public $grid;
    /* * @var List<Vector3>  */
    public $subdivGrid;
    /* * @var List<SubdivisionNode> */
    public $newGrid;
    /* * @var List<Obstacle> */
    /** @var \SplQueue */
    public $obstacles;
    /** @var Level */
    public $walkableMask;
    /* * @var Dictionary<int, int>  */
    /** @var \SplQueue */
    public $walkableRegionsDictionary/* = new Dictionary<int, int>()*/
    ;
    /** @var float */
    public $nodeDiameter;
    /** @var Vector3 */
    public $gridWorldSize;
    /** @var int */
    public $gridSizeX, $gridSizeY, $gridSizeZ;
    /** @var int */
    public $gridCount;
    /** @var int */
    public $subdivisionLevel = 10;
    /** @var int */
    public $newLevel = 3;
    /** @var Stopwatch */
    private $stopwatch;

    public function getSubdivisionDiameter(): float
    {
        return $this->nodeDiameter * $this->subdivisionLevel;
    }

    public function getNewDiameter(): float
    {
        return $this->nodeDiameter * $this->newLevel;
    }

    /** @var int */
    public $iterationCount;
    /** @var float */
    public $timeElapsed;
    /* * @var List<Node> */
    public $path;
    /** @var Grid */
    public static $instance;


    public function getMaxSize(): int
    {
        return $this->gridSizeX * $this->gridSizeY * $this->gridSizeZ;
    }

    public function Awake(): void
    {
        if ($this->Base != null) {
            self::$instance = $this;
            /*yield*/
            $this->BuildGrid(null);//StartCoroutine
        }
    }

    public function BuildGrid(GameObject $_Base): \Generator
    {//IEnumerator

        if ($_Base != null) {
            $this->Base = $_Base;
        }

        if ($this->Base/*.GetComponent<MeshRenderer>()*/ == null) {
            MainLogger::getLogger()->error("Grid Creation Error: Base surface has no MeshRenderer");
            yield;
        }

        //Create obstacle collection
        $obstacles = new \SplQueue();
        /** @var GameObject[] */
        $unwalkableObstacles = $this->GetObjectsInLayer((int)log($this->unwalkableMask, 2));
        for ($g = 0; $g < count($unwalkableObstacles); $g++) {
            /** @var Obstacle $currentUnwalkableObstacle */
            $currentUnwalkableObstacle = $unwalkableObstacles[$g];
            /** @var Obstacle */
            $ob = new Obstacle($currentUnwalkableObstacle, $currentUnwalkableObstacle/*.GetComponent<MeshRenderer>()*/, $currentUnwalkableObstacle->asVector3(), $currentUnwalkableObstacle->oldEulerAngles);
            $obstacles->add($obstacles->count(), $ob);
        }

        //Calculations for grid dimensions
        $this->gridWorldSize = new Vector3(abs($this->Base->getBoundingBox()->maxX - $this->Base->getBoundingBox()->minX), abs($this->Base->getBoundingBox()->maxY - $this->Base->getBoundingBox()->minY), abs($this->Base->getBoundingBox()->maxZ - $this->Base->getBoundingBox()->minZ));
        $this->nodeDiameter = 2 * $this->nodeRadius;
        $this->gridSizeX = (int)round($this->gridWorldSize->x / $this->nodeDiameter);
        $this->gridSizeY = max((int)round($this->gridWorldSize->y / $this->nodeDiameter), 1); //heightSteps;
        $this->gridSizeZ = (int)round($this->gridWorldSize->z / $this->nodeDiameter);

        if (count($this->walkableRegions) == 0) {
            MainLogger::getLogger()->error("No walkable regions have been declared");
            yield;
        }
        /** @var bool */
        $surfaceIsInWalkableMask = false;
        /** @var SurfaceType $surf */
        foreach ($this->walkableRegions as $surf) {
            $this->walkableMask |= $surf->layerMask;
            $this->walkableRegionsDictionary->add($this->walkableRegionsDictionary->count(), [(int)log($surf->layerMask, 2), $surf->penalty]);
            if (log($surf->layerMask, 2) == $this->Base->getLevel()->getId()) {
                $surfaceIsInWalkableMask = true;
            }
        }
        if (!$surfaceIsInWalkableMask) {
            MainLogger::getLogger()->error("Your surface '" . $this->Base->getSaveId() . "' is not in a walkable layer");
            yield;
        }

        yield;
        yield $this->CreateGrid();//StartCoroutine
    }

    private function CreateGrid(): \Generator
    { //Expedite this method. 30 platforms -> 11195712 grid nodes -> 17.75 seconds -> Hangs application
        $this->timeElapsed = microtime(true);
        $this->grid = new \SplQueue();
        $iterCt = 0;
        /** @var Vector3 */
        $worldBottomLeft = new Vector3($this->Base->getBoundingBox()->minX, $this->Base->getBoundingBox()->minY, $this->Base->getBoundingBox()->minZ);
        /** @var float */
        $heightStep = abs($this->Base->getBoundingBox()->maxY - $this->Base->getBoundingBox()->minY) / (int)$this->gridSizeY;

        //Grid creation

        switch ($this->testingMode) {

            case TestingMode::NEWTESTING :
                $ngsx = (int)round($this->gridWorldSize->x / $this->getNewDiameter());
                $ngsy = max((int)round($this->gridWorldSize->y / $this->getNewDiameter()), 1);
                $ngsz = (int)round($this->gridWorldSize->z / $this->getNewDiameter());
                /** @var float $nsdheightstep */
                $nsdheightstep = abs($this->Base->getBoundingBox()->maxY - $this->Base->getBoundingBox()->minY) / (float)$ngsy;
                //MainLogger::getLogger()->log(ngsy+", "+nsdheightstep);

                $newGrid = new \SplQueue();

                //Build subdivision grid
                for ($nxi = 0; $nxi <= $ngsx; $nxi++) { // '<=' Make sure it extends
                    for ($nyi = 0; $nyi <= $ngsy; $nyi++) {
                        for ($nzi = 0; $nzi <= $ngsz; $nzi++) { // '<=' Make sure it extends
                            $iterCt++;

                            /** @var Vector3 $nwpt */
                            $nwpt = $worldBottomLeft->add((new Vector3(0, 1))->multiply($nyi * $nsdheightstep))->add((new Vector3(0, 0, 1))->multiply(($nxi * $this->getNewDiameter() + ($this->getNewDiameter() * 0.5))))->add((new  Vector3(1))->multiply($nzi * $this->getNewDiameter() + ($this->getNewDiameter() * 0.5)));
                            if (Physics::CheckSphere($nwpt, $this->getNewDiameter() * 0.5, $this->walkableMask)) {
                                $subNode = new SubDivisionNodeExtended($nwpt, $worldBottomLeft, $heightStep, $this->nodeDiameter, $this->nodeRadius, $this->newLevel, $this->gridSizeX, $this->gridSizeY, $this->gridSizeZ);
                                $newGrid->add($newGrid->count(), $subNode);
                            }
                        }
                    }
                }

                //MainLogger::getLogger()->log("Found "+newGrid.Count+" nodes after "+iterCt+" iterations");

                for ($t = 0; $t < $newGrid->count(); $t++) {
                    $xArray = range($newGrid[$t]->startStopX[0], $newGrid[$t]->startStopX[1] - $newGrid[$t]->startStopX[0] + 1);
                    $yArray = range($newGrid[$t]->startStopY[0], $newGrid[$t]->startStopY[1] - $newGrid[$t]->startStopY[0] + 1);
                    $zArray = range($newGrid[$t]->startStopZ[0], $newGrid[$t]->startStopZ[1] - $newGrid[$t]->startStopZ[0] + 1);

                    for ($a = 0; $a < count($xArray); $a++) {
                        for ($b = 0; $b < count($yArray); $b++) {
                            for ($c = 0; $c < count($zArray); $c++) {
                                $iterCt++;
                                $x = $xArray[$a];
                                $y = $yArray[$b];
                                $z = $zArray[$c];
                                $worldPoint = $worldBottomLeft->add((new Vector3(0, 1))->multiply($y * $heightStep))->add((new Vector3(0, 0, 1))->multiply($x * $this->nodeDiameter + $this->nodeRadius))->add((new Vector3(1))->multiply($z * $this->nodeDiameter + $this->nodeRadius));
                                $this->PerformGridTest($worldPoint, $heightStep, $x, $y, $z);
                            }
                        }
                    }
                }
                $this->iterationCount = $iterCt;
                MainLogger::getLogger()->log("Grid successfully created with " . $this->gridCount . " nodes. Optimized from " . $this->getMaxSize() . " nodes: [" . $this->gridSizeX . ", " . $this->gridSizeY . ", " . $this->gridSizeZ . "] by new grid [" . $ngsx . ", " . $ngsy . ", " . $ngsz . "]. Operation completed from " . $newGrid->count() . " subdivision nodes with " . $iterCt . " iterations in " . (microtime(true) - $this->timeElapsed) . " seconds.");

                break;

            //Subdivision Testing
            case TestingMode::SUBDIVISIONTESTING :
                $gsx = (int)round($this->gridWorldSize->x / $this->getSubdivisionDiameter());
                $gsy = max((int)round($this->gridWorldSize->y / $this->getSubdivisionDiameter()), 1);
                $gsz = (int)round($this->gridWorldSize->z / $this->getSubdivisionDiameter());
                /** @var float $sdheightstep */
                $sdheightstep = abs($this->Base->getBoundingBox()->maxY - $this->Base->getBoundingBox()->minY) / (float)$gsy;

                /** @var \SplQueue $subdivGrid */
                $subdivGrid = new \SplQueue();//<Vector3>

                //Build subdivision grid
                for ($xi = 0; $xi <= $gsx; $xi++) { // '<=' Make sure it extends
                    for ($yi = 0; $yi < $this->gridSizeY; $yi++) {
                        for ($zi = 0; $zi <= $gsz; $zi++) { // '<=' Make sure it extends
                            $iterCt++;

                            /** @var Vector3 */
                            $wpt = $worldBottomLeft + (new Vector3(0, 1))->multiply($yi * $sdheightstep)->add((new Vector3(0, 0, 1))->multiply(($xi * $this->getSubdivisionDiameter() + ($this->getSubdivisionDiameter() * 0.5))))->add((new Vector3(1))->multiply($zi * $this->getSubdivisionDiameter() + ($this->getSubdivisionDiameter() * 0.5)));
                            if (Physics::CheckSphere($wpt, $this->getSubdivisionDiameter() * 0.5, $this->walkableMask)) {
                                $subdivGrid->add($subdivGrid->count(), $wpt);
                            }
                        }
                    }
                }

                //Build grid from subdivision nodes
                for ($i = 0; $i < $subdivGrid->count(); $i++) {
                    /** @var Vector3 */
                    $snP = $subdivGrid[$i]; //Position of subdiv node
                    /** @var Vector3 */
                    $snPLowLeft = $snP->add($snP->x - $this->nodeDiameter * 0.5 * $this->subdivisionLevel, 0, $snP->z - $this->nodeDiameter * 0.5 * $this->subdivisionLevel);
                    for ($u = 0; $u < $this->subdivisionLevel; $u++) { //Raycast testing on XZ axis
                        for ($v = 0; $v < $this->subdivisionLevel; $v++) {
                            $iterCt++;
                            /** @var Vector3 */
                            $worldPos = (new Vector3($u * $this->nodeDiameter + $this->nodeRadius, 0, $v * $this->nodeDiameter + $this->nodeRadius))->add($snPLowLeft);
                            /** @var int */
                            $x = clamp((int)round(($worldPos->x - $worldBottomLeft->x - $this->nodeRadius) / $this->nodeDiameter), 0, $this->gridSizeX - 1);
                            /** @var int */
                            $y = clamp((int)round(($worldPos->y - $worldBottomLeft->y) / $heightStep), 0, $this->gridSizeY - 1);
                            /** @var int */
                            $z = clamp((int)round(($worldPos->z - $worldBottomLeft->z - $this->nodeRadius) / $this->nodeDiameter), 0, $this->gridSizeZ - 1);
                            $this->PerformGridTest($worldPos, $heightStep, $x, $y, $z);
                        }
                    }
                }
                $this->iterationCount = $iterCt;
                MainLogger::getLogger()->log("Grid successfully created with " . $this->gridCount . " nodes. Optimized from " . $this->getMaxSize() . " nodes: [" . $this->gridSizeX . ", " . $this->gridSizeY . ", " . $this->gridSizeZ . "] by subdivision grid [" . $gsx . ", " . $gsy . ", " . $gsz . "]. Operation completed from " . $subdivGrid->count() . " subdivision nodes with " . $iterCt . " iterations in " . (microtime(true) - $this->timeElapsed) . " seconds.");
                break;

            //Sweep Testing
            case TestingMode::SWEEPTESTING :
                for ($x = 0; $x < $this->gridSizeX; $x++) {  //Optimize this terrible block
                    for ($y = 0; $y < $this->gridSizeY; $y++) {
                        for ($z = 0; $z < $this->gridSizeZ; $z++) {
                            $iterCt++;
                            /** @var Vector3 */
                            $worldPoint = $worldBottomLeft->add(((new Vector3(0, 1))->multiply($y * $heightStep)))->add(((new Vector3(0, 0, 1))->multiply($x * $this->nodeDiameter + $this->nodeRadius)))->add(((new Vector3(1))->multiply($z * $this->nodeDiameter + $this->nodeRadius)));
                            $this->PerformGridTest($worldPoint, $heightStep, $x, $y, $z);
                        }
                        //y hold
                        //if (y % 120 == 0) {
                        //	yield return null;
                        //}
                    }
                }
                MainLogger::getLogger()->log("Grid successfully created with " . $this->gridCount . " nodes. Optimized from " . $this->getMaxSize() . " nodes: [" . $this->gridSizeX . ", " . $this->gridSizeY . ", " . $this->gridSizeZ . "]. Operation completed with " . $iterCt . " iterations in " . (microtime(true) - $this->timeElapsed) . " seconds.");
                break;

            //Benchmark Mode
            case TestingMode::BENCHMARKMODE :
                //Perform sweep testing, then subdivision testing, and report time and iteration counts
                break;
        }

        yield;
    }

    public function Optimize(): \Generator
    {
        //Dictionary<int, long> Times = new Dictionary<int, long>();
        $Times = new \SplQueue();
        //Dictionary<int, int> Iterations = new Dictionary<int, int>();
        $Iterations = new \SplQueue();
        for ($i = 1; $i < 25; $i++) {
            $this->gridCount = 0;
            $this->grid = null;
            $this->newGrid = null;
            $this->subdivGrid = null;
            $this->newLevel = $i;
            yield $this->CreateGrid();//StartCoroutine
            $this->stopwatch::Stop();
            $Iterations->add($i, $this->iterationCount);
            $Times->add($i, $this->stopwatch::ElapsedMilliseconds());
            $this->stopwatch::Reset();
        }
        /** @var float */
        $bestTime = $Times[1];
        /** @var int */
        $bestIterations = $Iterations[1];
        /** @var int */
        $bestTimeIterations = 0;
        /** @var int */
        $bestIterationsIterations = 0;
        /** @var string */
        $times = "";
        /** @var string */
        $iters = "";
        for ($t = 1; $t < $Times->count(); $t++) {
            $times .= "Subdivision level: " . $t . ". Time spent: " . ($Times[$t] / 1000) . " seconds\n";
            $iters .= "Subdivision level: " . $t . ". Iteration count: " . $Iterations[$t] . "\n";
            if (($Times[$t] / 1000) < $bestTime) {
                $bestTime = $Times[$t] / 1000;
                $bestTimeIterations = $t;
            }
            if ($Iterations[$t] < $bestIterations) {
                $bestIterations = $Iterations[$t];
                $bestIterationsIterations = $t;
            }
        }
        MainLogger::getLogger()->log("Best time is " . $bestTime . " seconds at subdivision level " . $bestTimeIterations);
        MainLogger::getLogger()->log("Best iteration count is " . $bestIterations . " at subdivision level " . $bestIterationsIterations);
        MainLogger::getLogger()->log($iters);
        MainLogger::getLogger()->log($times);
    }

    public function PerformGridTest(Vector3 $worldPoint, float $heightStep, int $x, int $y, int $z): void
    {
        /** @var Vector3 */
        $raycastPoint = $worldPoint->add((new Vector3(0, 1))->multiply(max($heightStep, 0.1))); //Max is for flat surface accommodation
        /** @var Ray */
        $cray = new Ray($raycastPoint, new Vector3(0, -1));
        /** @var RayTraceResult|null $cRayHit */
        $cRayHit = null;

        if (Physics::Raycast($cray, $cRayHit, max($heightStep, 0.15))) {
            if ($cRayHit->getBoundingBox() === $this->Base->getBoundingBox() || Util::ContainsKey($this->walkableRegionsDictionary, $this->Base->getLevel())) { //Build grid only on Base//TODO switched stuff to BB.. shitty testing.. especially when 2 entities are at the exact same position..
                /** @var Vector3 $actualWorldPoint */
                $actualWorldPoint = $cRayHit->getHitVector(); //position where node should be //used instead of worldPoint

                //Walkable testing and obstacle information
                /** @var bool */
                $walkable = !(Physics::CheckSphere($actualWorldPoint, $this->nodeRadius, $this->unwalkableMask));
                /** @var bool */
                $canDoObstacleUpdate = false;
                /*Collider[]*/
                $obses = Physics::OverlapSphere($actualWorldPoint, $this->nodeRadius, $this->unwalkableMask);
                if (count($obses) > 0) {
                    $walkable = false;
                    $canDoObstacleUpdate = true;
                }

                //Raycasting for walkable regions
                /** @var int */
                $movePenalty = 0;
                if ($walkable) {
                    /** @var RayTraceResult $hit */
                    $hit = null;
                    /** @var Ray */
                    $ray = new Ray($actualWorldPoint->add((new Vector3(0, 1))->multiply($this->nodeRadius)), new Vector3(0, -1));
                    if (Physics::Raycast($ray, $hit, $this->nodeDiameter, $this->walkableMask)) {
                        Util::TryGetValue($this->walkableRegionsDictionary, $this->Base->getLevel()->getBlockIdAt($hit->getHitVector()), $movePenalty);
                    }
                }

                //Make new node in grid
                $this->gridCount++;
                $this->grid[] = [[$x, $y, $z], new Node($walkable, $actualWorldPoint, new Vector3($x, $y, $z), $movePenalty)];

                //Add this node to the affected nodes of the obstacle
                if ($canDoObstacleUpdate) {
                    for ($d = 0; $d < $this->obstacles->count(); $d++) {
                        if ($this->obstacles[$d]->gameObject === $obses[0]->gameObject) {
                            /** @var Node */
                            $value = null;
                            Util::TryGetValue($this->grid, [$x, $y, $z], $value);//TODO CHECK
                            $this->obstacles[$d]->affectedNodes->add($value);
                            break;
                        }
                    }
                }
            }
        }
    }

    public function Update(): void
    {
        if ($this->updateGrid) {
            $this->UpdateObstacles();
        }

        /*if (Input.GetKeyUp(KeyCode.O)) {
            yield Optimize();//TODO find a different way to activate (command?)
        }*/
    }

    private function UpdateObstacles(): void
    {
        //For dynamic number of obstacles in scene
        if (!$this->fixedObstaclesCount) {
            /** @var GameObject[] $unwalkableObstacles */
            $unwalkableObstacles = $this->GetObjectsInLayer((int)log($this->unwalkableMask, 2));
            if (count($unwalkableObstacles) != $this->obstacles->count()) {
                $this->obstacles = new \SplQueue();
                for ($g = 0; $g < count($unwalkableObstacles); $g++) {
                    /** @var Obstacle */
                    $ob = new Obstacle($unwalkableObstacles[$g], $unwalkableObstacles[$g]/*.GetComponent<MeshRenderer>()*/, $unwalkableObstacles[$g]->asVector3(), new Vector3($unwalkableObstacles[$g]->getPitch(), $unwalkableObstacles[$g]->getYaw()));
                    $this->obstacles->add($this->obstacles->count(), $ob);
                }
            }
        }

        //Intersection test
        if ($this->obstacles->count() > 0) { //Do surface update mode check before this line
            for ($i = 0; $i < $this->obstacles->count(); $i++) {
                /** @var float */
                $delta = ($this->obstacles[$i]->gameObject->asPosition()->distanceSquared($this->obstacles[$i]->oldPosition));
                /** @var float */
                $deltaRot = ($this->obstacles[$i]->gameObject->getYaw() ** 2 + $this->obstacles[$i]->oldEulerAngles->y ** 2);

                if (!Util::Approximate($delta, 0) || !Util::Approximate($deltaRot, 0)) { //Do unwalkable testing here
                    //MainLogger::getLogger()->log("Obstacle "+obstacles[i].gameObject.name+" has moved");

                    //Make all affected nodes walkable //This creates issues with obstacle overlapping/intersection
                    for ($s = 0; $s < $this->obstacles[$i]->affectedNodes->count(); $s++) { //enumerates each node in an obstacle's affected nodes
                        //if (Physics.OverlapSphere(obstacles[i].affectedNodes[s].worldPosition, nodeRadius, unwalkableMask).Length < 2) {
                        $this->obstacles[$i]->affectedNodes[$s]->walkable = true;
                        //}
                    }
                    $this->obstacles[$i]->affectedNodes = new \SplQueue();

                    //Get all nodes in the AABB bounds of the obstacle
                    /** @var Node[] */
                    $newNodes = $this->GetAllNodesInArea(Util::GetAABBMin($this->obstacles[$i]->renderer), Util::GetAABBMax($this->obstacles[$i]->renderer)->subtract(0, Util::GetAABBSize($this->obstacles[$i]->renderer)->y)); //max - size.y to normalize to XZ axis

                    //Do physics CheckSphere to check for obstacle contact then set walkable accordingly and update obstacle's affectedNodes
                    for ($p = 0; $p < count($newNodes); $p++) {
                        if (Physics::CheckSphere($newNodes[$p]->worldPosition, $this->nodeRadius, $this->unwalkableMask) && $newNodes[$p]->walkable) {
                            $newNodes[$p]->walkable = false;
                            $this->obstacles[$i]->affectedNodes->add($this->obstacles->count(), $newNodes[$p]);
                        }
                    }
                }

                $this->obstacles[$i]->oldPosition = $this->obstacles[$i]->gameObject->asPosition();
                $this->obstacles[$i]->oldEulerAngles = $this->obstacles[$i]->gameObject->getYaw();
            }
        }
    }

    /**
     * @param Vector3 $lowerLeftCorner
     * @param Vector3 $upperRightCorner
     * @return \SplQueue Node[]
     */
    public function GetAllNodesInArea(Vector3 $lowerLeftCorner, Vector3 $upperRightCorner): \SplQueue
    { //With respect to the XZ axis //In world coordinates //This function takes 0.3ms to execute
        $nodes = new \SplQueue();
        /** @var int */
        $xIters = (int)round(($upperRightCorner->x - $lowerLeftCorner->x) / $this->nodeDiameter);
        /** @var int */
        $yIters = max((int)round(($upperRightCorner->y - $lowerLeftCorner->y) / $this->nodeDiameter), 1);
        /** @var int */
        $zIters = (int)round(($upperRightCorner->z - $lowerLeftCorner->z) / $this->nodeDiameter);

        for ($x = 0; $x <= $xIters; $x++) {
            for ($y = 0; $y <= $yIters; $y++) { //Problematic term
                for ($z = 0; $z <= $zIters; $z++) {
                    /** @var float */
                    $xcord = $lowerLeftCorner->x + ($x * $this->nodeDiameter);
                    /** @var float */
                    $ycord = $lowerLeftCorner->y + ($y * $this->nodeDiameter);
                    /** @var float */
                    $zcord = $lowerLeftCorner->z + ($z * $this->nodeDiameter);

                    /** @var Node */
                    $n = $this->NodeFromWorldPoint(new Vector3($xcord, $ycord, $zcord));

                    if ($n != null && !Util::Contains($nodes, $n)) {
                        $nodes->add($nodes->count(), $n);
                    }
                }
            }
        }

        return iterator_to_array($nodes);
    }

    public function GetNeighbors(Node $node): \SplQueue
    { //Fix this block //Compensate for empty nodes in grid
        /** @var \SplQueue Node[] */
        $neighbors = new \SplQueue();
        for ($x = -1; $x <= 1; $x++) { //Searches in the XZ Axis
            for ($z = -1; $z <= 1; $z++) {
                if ($x == 0 && $z == 0) continue;
                if ($node->gridPosition->x + $x >= 0 && $node->gridPosition->x + $x < $this->gridSizeX && $node->gridPosition->z + $z >= 0 && $node->gridPosition->z + $z < $this->gridSizeZ) {
                    if ($this->gridSizeY > 1) {
                        for ($y = -1; $y <= 1; $y++) { //Y Axis testing
                            if ($node->gridPosition->y + $y < $this->gridSizeY && $node->gridPosition->y + $y >= 0) {
                                /** @var Node */
                                $vnode = null;
                                Util::TryGetValue($this->grid, [(int)$node->gridPosition->x + $x, (int)$node->gridPosition->y + $y, (int)$node->gridPosition->z + $z], $vnode);
                                if ($vnode != null) { //Accommodation for empty nodes //Requires fix for y axis, index out of range exception
                                    $neighbors->add($neighbors->count(), $vnode);
                                    break;
                                }
                            }
                        }
                    } else {
                        /** @var Node */
                        $vnode = null;
                        Util::TryGetValue($this->grid, [(int)$node->gridPosition->x + $x, (int)$node->gridPosition->y, (int)$node->gridPosition->z + $z], $vnode);
                        if ($vnode != null) { //Accommodation for empty nodes
                            $neighbors->add($neighbors->count(), $vnode);
                        }
                    }
                }
            }
        }
        return $neighbors;
    }

    public function NodeFromWorldPoint(Vector3 $worldPos): Node
    { //Requires biggest fix
        /** @var Node */
        $node = null;
        //MainLogger::getLogger()->log(Base.transform.position+", "+Base.GetComponent<MeshRenderer>().bounds.center);

        //Normalize to Base-space coordinates
        /** @var Vector3 $worldPos */
        $worldPos = $worldPos->subtract(Util::GetAABBCenter($this->Base->getBoundingBox())); //Should be centre, not pivot. Use centroid?

        //Perform grid testing //Fix this block //Broken
        /** @var Vector3 $percent */
        $percent = new Vector3(($worldPos->x + ($this->gridWorldSize->x / 2)) / $this->gridWorldSize->x, ($worldPos->y + ($this->gridWorldSize->y / 2)) / $this->gridWorldSize->y, ($worldPos->z + ($this->gridWorldSize->z / 2)) / $this->gridWorldSize->z);
        $percent->setComponents(
            (int)round(($this->gridSizeX - 1) * clamp($percent->x, 0, 1)),
            (int)round(($this->gridSizeY - 1) * clamp($percent->y, 0, 1)),
            (int)round(($this->gridSizeZ - 1) * clamp($percent->z, 0, 1))
        );
        /** @var Node $node */
        $node = null;
        Util::TryGetValue($this->grid, [(int)$percent->x, (int)$percent->y, (int)$percent->z], $node);
        //MainLogger::getLogger()->log("Grid testing gives "+percent);

        //if grid testing fails, perform nearest-node sweep testing
        if ($node == null) {
            /** @var int */
            $iterCount = 0;
            for ($x = 0; $x < 2 * $this->gridSizeX; $x++) { //Perform sweep from grid testing coordinates outward
                for ($y = 0; $y < 2 * $this->gridSizeY; $y++) {
                    for ($z = 0; $z < 2 * $this->gridSizeZ; $z++) {

                        /** @var int */
                        $xCord = clamp((int)$percent->x + ($x % 2 == 0 ? $x / 2 : -($x / 2 + 1)), 0, $this->gridSizeX - 1);
                        /** @var int */
                        $yCord = clamp((int)$percent->y + ($y % 2 == 0 ? $y / 2 : -($y / 2 + 1)), 0, $this->gridSizeY - 1);
                        /** @var int */
                        $zCord = clamp((int)$percent->z + ($z % 2 == 0 ? $z / 2 : -($z / 2 + 1)), 0, $this->gridSizeZ - 1);
                        $iterCount++;
                        /** @var Node $node */
                        $node = null;
                        Util::TryGetValue($this->grid, [$xCord, $yCord, $zCord], $node);//Assign node here
                        if ($node != null) {
                            MainLogger::getLogger()->log("Grid testing failed. Nearest-node sweep testing found node at " . $node->gridPosition . " from " . $percent . " after " . $iterCount . " loop iterations");
                            return $node;
                        }
                    }
                }
            }
        }

        return $node;
    }

    /*public function OnDrawGizmos () :void {
        switch (gridDisplayMode) {
            case GridDisplayMode.Full :
                if (Base != null) {
                    gridWorldSize = Base.GetComponent<MeshRenderer>().bounds.size;
                Gizmos.DrawWireCube(Base.GetComponent<MeshRenderer>().bounds.center, gridWorldSize);
            }

                if (grid != null) {
                    foreach (Node node in grid) {
                        if (node != null) {
                            Gizmos.color = node.walkable ? Color.white : Color.red;
                            if (path != null && path.Contains(node)) Gizmos.color = Color.cyan;
                            Gizmos.DrawCube(node.worldPosition, new Vector3(nodeDiameter-0.1f, 0.2f, $this->nodeDiameter-0.1f));
                    }
                    }
            }
                break;
            case GridDisplayMode.SubdivisionGrid :
                if (Base != null) {
                    gridWorldSize = Base.GetComponent<MeshRenderer>().bounds.size;
                Gizmos.DrawWireCube(Base.GetComponent<MeshRenderer>().bounds.center, gridWorldSize);
            }
                if (subdivGrid != null) {
                    foreach (Vector3 sg in subdivGrid) {
                        Gizmos.color = Color.magenta;
                        Gizmos.DrawCube(sg, new Vector3($this->getSubdivisionDiameter()-0.1f, 0.2f, $this->getSubdivisionDiameter()-0.1f));
                }
            }
                break;
            case GridDisplayMode.NewGrid :
                if (Base != null) {
                    gridWorldSize = Base.GetComponent<MeshRenderer>().bounds.size;
                Gizmos.DrawWireCube(Base.GetComponent<MeshRenderer>().bounds.center, gridWorldSize);
            }
                if (newGrid != null) {
                    foreach (SubdivisionNode sg in newGrid) {
                        Gizmos.color = Color.yellow;
                        Gizmos.DrawCube(sg.position, new Vector3(NewDiameter-0.1f, abs($this->Base->getBoundingBox()->maxY- $this->Base->getBoundingBox()->minY) / (max((int)round(gridWorldSize.y / NewDiameter), 1)), NewDiameter-0.1f));
                }
            }
                break;
            case GridDisplayMode.PathOnly :
                if (grid != null) {
                    foreach (Node node in grid) {
                        if (path != null && path.Contains(node)) {
                            Gizmos.color = Color.cyan;
                            Gizmos.DrawCube(node.worldPosition, new Vector3(nodeDiameter-0.1f, 0.2f, $this->nodeDiameter-0.1f));
                    }
                    }
            }
                break;
            case GridDisplayMode.ObstaclesOnly :
                if (grid != null) {
                    foreach (Node node in grid) {
                        if (node != null && !node.walkable) {
                            Gizmos.color = Color.red;
                            Gizmos.DrawCube(node.worldPosition, new Vector3(nodeDiameter-0.1f, 0.2f, $this->nodeDiameter-0.1f));
                    }
                    }
            }
                break;
        }
    }*/

    /**
     * @param int $layer
     * @return GameObject[]
     */
    private static function GetObjectsInLayer(int $layer): array
    {
        $ret = new \SplQueue();
        $level = Server::getInstance()->getLevel($layer);
        foreach ($level->getEntities() as $t) {
            if (!$t instanceof ItemEntity && !$t instanceof ExperienceOrb && !$t instanceof PrimedTNT && !$t instanceof Painting && !$t instanceof FallingBlock && !$t instanceof Projectile)
                $ret->add($t);

        }
        return iterator_to_array($ret);
    }
}