<?php

class Point
{
    public $x;
    public $y;
    public $g;
    public $h;
    public $f;

    public $cost = 0;
    public $isWalkable = true;
    public $isOpened = false;
    public $isClosed = false;

    /**
     * @var Point
     */
    public $parent = null;

    public function toJson()
    {
        return [
            'x' => $this->x,
            'y' => $this->y,
            'g' => $this->g,
            'h' => $this->h,
            'f' => $this->f,
            'cost' => $this->cost,
        ];
    }
}

class MinHeap extends SplMinHeap
{
    protected function compare($value1, $value2)
    {
        return $value2->f - $value1->f;
    }
}

class AStar
{
    protected $map;
    /**
     * @var SplQueue
     */
    protected $openList;

    /**
     * @var SplQueue
     */
    protected $closedList;



    public function __construct($map)
    {
        $tiles = [];
        foreach ($map as $y => $line) {
            $tiles[$y] = [];
            $row = str_split($line);
            foreach ($row as $x => $col) {
                $point = new Point();
                $point->x = $x;
                $point->y = $y;
                if ($col == 'X') {
                    $point->cost = PHP_INT_MAX;
                    $point->isWalkable = false;
                } else if ($col == '.'){
                    $point->cost = 0;
                    $point->isWalkable = true;
                } else {
                    $point->cost = intval($col);
                    $point->isWalkable = true;
                }

                $tiles[$y][$x] = $point;
            }
        }
        $this->map = $tiles;
    }

    public function find($x, $y, $toX, $toY)
    {
        $from = $this->map[$y][$x];
        $to = $this->map[$toY][$toX];

        $openList = new MinHeap();

        $openList->insert($from);

        while (!$openList->isEmpty()) {
            // 获得f最小的点
            $point = $openList->extract();;
            $point->isClosed = true;

            //找出它相邻的点
            $nearPoints = $this->getNearPoints($point);

            foreach ($nearPoints as $nearPoint) {
                if (!$nearPoint->isWalkable || $nearPoint->isClosed) {
                    continue;
                } else if ($nearPoint->isOpened){
                    $g = $point->g + $nearPoint->cost + 1;
                    $h = abs($nearPoint->x - $to->x)+abs($nearPoint->y - $to->y);
                    $f = $h + $g;

                    if ($f < $nearPoint->f) {
                        $nearPoint->f = $f;
                        $nearPoint->g = $g;
                        $nearPoint->h = $h;
                        $nearPoint->parent = $point;
                    }
                } else {
                    $g = $point->g + $nearPoint->cost + 1;
                    $h = abs($nearPoint->x - $to->x)+abs($nearPoint->y - $to->y);
                    $f = $h + $g;

                    $nearPoint->f = $f;
                    $nearPoint->g = $g;
                    $nearPoint->h = $h;
                    $nearPoint->parent = $point;
                    $nearPoint->isOpened = true;

                    $openList->insert($nearPoint);
                }
                
                if ($nearPoint == $to) {
                    return $nearPoint;
                }
            }
            
        }
        
        return null;
    }

    /**
     * @param Point $point
     * @return SplStack
     */
    public function getPath(Point $point)
    {
        $path = new SplStack();
        while ($point) {
            $path->push($point);
            if ($point->parent) {
                $point = $point->parent;
            } else {
                break;
            }
        }

        return $path;
    }
    
    protected function getNearPoints(Point $point)
    {
        $points = [];
        if (isset($this->map[$point->y-1][$point->x])) {
            $points[] = $this->map[$point->y-1][$point->x];
        }
        if (isset($this->map[$point->y][$point->x-1])) {
            $points[] = $this->map[$point->y][$point->x-1];
        }
        if (isset($this->map[$point->y+1][$point->x])) {
            $points[] = $this->map[$point->y+1][$point->x];
        }
        if (isset($this->map[$point->y][$point->x+1])) {
            $points[] = $this->map[$point->y][$point->x+1];
        }

        return $points;
    }
}
