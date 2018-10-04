<?php


namespace xenialdan\astar3d;

use SplMinHeap;

class MinHeap extends SplMinHeap
{
    protected function compare($value1, $value2)
    {
        return $value2->f - $value1->f;
    }
}