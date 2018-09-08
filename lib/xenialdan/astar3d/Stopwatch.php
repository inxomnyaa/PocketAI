<?php


namespace xenialdan\astar3d;


class Stopwatch
{
private static $startTimes=[];

public static function start($timerName = "default"){
    self::$startTimes[$timerName] = microtime(true);
}

public static function ElapsedMilliseconds($timerName="default"){
    return microtime(true) - self::$startTimes[$timerName];
}

    public static function Stop($timerName="default")
    {//TODO?
    }

    public static function Reset($timerName="default")
    {
        unset(self::$startTimes[$timerName]);
    }
}