<?php


namespace xenialdan\astar3d;


use pocketmine\math\Vector3;

class SubDivisionNodeExtended extends SubdivisionNode
{
    public function __construct(Vector3 $position, Vector3 $worldBottomLeft, float $heightStep, float $nodeDiameter, float $nodeRadius, int $newLevel, int $gridSizeX, int $gridSizeY, int $gridSizeZ)
    { //Calculate startStopIndices here
        $this->position = $position;
        $snPLowLeft = $position;
        $snPLowLeft->x -= $nodeDiameter * 0.5 * $newLevel;
        $snPLowLeft->y -= $nodeDiameter * 0.5 * $newLevel;
        $snPLowLeft->z -= $nodeDiameter * 0.5 * $newLevel;

        $worldPos0 = new Vector3($nodeRadius, $nodeRadius, $nodeRadius) + $snPLowLeft;
        $worldPos1 = new Vector3(($newLevel - 1) * $nodeDiameter + $nodeRadius, ($newLevel - 1) * $nodeDiameter + $nodeRadius, ($newLevel - 1) * $nodeDiameter + $nodeRadius) + $snPLowLeft;

        $x0 = clamp((int)round(($worldPos0->x - $worldBottomLeft->x - $nodeRadius) / $nodeDiameter), 0, $gridSizeX - 1);
        $x1 = clamp((int)round(($worldPos1->x - $worldBottomLeft->x - $nodeRadius) / $nodeDiameter), 0, $gridSizeX - 1);
        $y0 = clamp((int)round(($worldPos0->y - $worldBottomLeft->y) / $heightStep), 0, $gridSizeY - 1);
        $y1 = clamp((int)round(($worldPos1->y - $worldBottomLeft->y) / $heightStep), 0, $gridSizeY - 1);
        $z0 = clamp((int)round(($worldPos0->z - $worldBottomLeft->z - $nodeRadius) / $nodeDiameter), 0, $gridSizeZ - 1);
        $z1 = clamp((int)round(($worldPos1->z - $worldBottomLeft->z - $nodeRadius) / $nodeDiameter), 0, $gridSizeZ - 1);

        $this->startStopX = [$x0, $x1];
        $this->startStopY = [$y0, $y1];
        $this->startStopZ = [$z0, $z1];
    }
}

function clamp($current, $min, $max)
{
    return max($min, min($max, $current));
}