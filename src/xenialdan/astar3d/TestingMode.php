<?php

namespace xenialdan\astar3d;

class TestingMode extends \SplEnum
{
    const __default = self::SWEEPTESTING;
    const SWEEPTESTING = 0;
    const SUBDIVISIONTESTING = 1;
    const NEWTESTING = 2;
    const BENCHMARKMODE = 3;
}