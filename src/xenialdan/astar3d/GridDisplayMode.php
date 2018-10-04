<?php

namespace xenialdan\astar3d;

class GridDisplayMode extends \SplEnum
{
    const __default = self::FULL;
    const FULL = 0;
    const SUBDIVISIONGRID = 1;
    const NEWGRID = 2;
    const PATHONLY = 3;
    const OBSTACLESONLY = 4;
    const NOTHING = 5;
}