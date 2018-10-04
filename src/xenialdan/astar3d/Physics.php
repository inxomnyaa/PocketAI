<?php


namespace xenialdan\astar3d;


use pocketmine\level\Level;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\RayTraceResult;
use pocketmine\math\Vector3;

class Physics
{

    public static function Raycast(Ray $rayIn, RayTraceResult &$raycastHit, float $radius, /*LayerMask*/
                                   $value = null): bool
    {
        $raycastHit = (new AxisAlignedBB(-$radius, -$radius, -$radius, $radius, $radius, $radius))->calculateIntercept($rayIn->from, $rayIn->to);
        return false;
    }

    /**
     * @param Vector3 $actualWorldPoint
     * @param float $nodeRadius
     * @param Level $layerMask
     * @return Obstacle[]
     */
    public static function OverlapSphere(Vector3 $actualWorldPoint, float $nodeRadius, Level $layerMask): array
    {
        $o = [];
        $ce = $layerMask->getCollidingEntities((new AxisAlignedBB($actualWorldPoint->getX(), $actualWorldPoint->getY(), $actualWorldPoint->getZ()))->expand($nodeRadius));
        foreach ($ce as $entity) {
            $o[] = new Obstacle($entity, $entity, $entity->asVector3(), new Vector3($entity->getPitch(), $entity->getYaw()));
        }
        return $o;
    }

    /**
     * @param Vector3 $position Center of the sphere.
     * @param float $radius Radius of the sphere.
     * @param Level $layerMask A Layer mask that is used to selectively ignore colliders when casting a capsule.
     * @internal $queryTriggerInteraction Specifies whether this query should hit Triggers.
     * @return bool
     */
    public static function CheckSphere(Vector3 $position, float $radius, Level $layerMask): bool
    {
        return count($layerMask->getCollidingEntities((new AxisAlignedBB($position->getX(), $position->getY(), $position->getZ()))->expand($radius))) > 0;
    }
}