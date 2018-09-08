<?php


namespace xenialdan\astar3d;


use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;

class Util
{

    /**
     * Helper function to check if a \SplQueue contains an element
     *
     * @param \SplQueue $queue
     * @param $element
     * @return bool True if the element exists
     */
    public static function Contains(\SplQueue $queue, $element): bool
    {
        return in_array($element, iterator_to_array(clone $queue));
    }

    /**
     * Helper function to check if a \SplQueue contains a key
     *
     * @param \SplQueue $queue
     * @param string $key
     * @return bool True if the key exists
     */
    public static function ContainsKey(\SplQueue $queue, string $key): bool
    {
        return array_key_exists($key, iterator_to_array(clone $queue));
    }

    /**
     * Helper function to get a value if element exists in a \SplQueue
     *
     * @param \SplQueue $queue
     * @param $element
     * @param $value
     */
    public static function TryGetValue(\SplQueue $queue, $element, &$value): void
    {
        if (self::Contains($queue, $element)) $value = $queue[array_search($element, iterator_to_array(clone  $queue))];
    }

    /**
     * Helper function to get the center of an AABB
     *
     * @param AxisAlignedBB $axisAlignedBB
     * @return Vector3
     */
    public static function GetAABBCenter(AxisAlignedBB $axisAlignedBB): Vector3
    {
        return new Vector3(($axisAlignedBB->minX + $axisAlignedBB->maxX) / 2, ($axisAlignedBB->minY + $axisAlignedBB->maxY) / 2, ($axisAlignedBB->minZ + $axisAlignedBB->maxZ) / 2);
    }

    /**
     * Helper function to get the min Vector3 of an AABB
     *
     * @param AxisAlignedBB $axisAlignedBB
     * @return Vector3
     */
    public static function GetAABBMin(AxisAlignedBB $axisAlignedBB): Vector3
    {
        return new Vector3($axisAlignedBB->minX, $axisAlignedBB->minY, $axisAlignedBB->minZ);
    }

    /**
     * Helper function to get the min Vector3 of an AABB
     *
     * @param AxisAlignedBB $axisAlignedBB
     * @return Vector3
     */
    public static function GetAABBMax(AxisAlignedBB $axisAlignedBB): Vector3
    {
        return new Vector3($axisAlignedBB->maxX, $axisAlignedBB->maxY, $axisAlignedBB->maxZ);
    }

    /**
     * Helper function to get the min Vector3 of an AABB
     *
     * @param AxisAlignedBB $axisAlignedBB
     * @return Vector3
     */
    public static function GetAABBSize(AxisAlignedBB $axisAlignedBB): Vector3
    {
        return new Vector3(abs($axisAlignedBB->maxX - $axisAlignedBB->minX), abs($axisAlignedBB->maxY - $axisAlignedBB->minY), abs($axisAlignedBB->maxZ - $axisAlignedBB->minZ));
    }

    public static function Approximate(float $i, float $j):bool{
        $epsilon = 0.00001;
        return abs($i-$j) < $epsilon;
    }
}