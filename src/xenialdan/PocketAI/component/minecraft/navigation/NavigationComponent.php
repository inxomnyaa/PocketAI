<?php


namespace xenialdan\PocketAI\component\minecraft\navigation;


use xenialdan\PocketAI\component\BaseComponent;

abstract class NavigationComponent extends BaseComponent
{
    /** @var bool $avoid_portals Tells the pathfinder to avoid portals (like nether portals) when finding a path */
    public $avoid_portals = false;
    /** @var bool $avoid_sun Whether or not the pathfinder should avoid tiles that are exposed to the sun when creating paths */
    public $avoid_sun = false;
    /** @var bool $avoid_water Tells the pathfinder to avoid water when creating a path */
    public $avoid_water = false;
    /** @var bool $can_float Tells the pathfinder whether or not it can float in water */
    public $can_float = false;
    /** @var bool $can_open_doors Tells the pathfinder that it can path through a closed door assuming the AI will open the door */
    public $can_open_doors = false;
    /** @var bool $can_pass_doors Whether a path can be created through a door */
    public $can_pass_doors = true;

    /**
     * NavigationComponent constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->avoid_portals = $values['avoid_portals'] ?? $this->avoid_portals;
        $this->avoid_sun = $values['avoid_sun'] ?? $this->avoid_sun;
        $this->avoid_water = $values['avoid_water'] ?? $this->avoid_water;
        $this->can_float = $values['can_float'] ?? $this->can_float;
        $this->can_open_doors = $values['can_open_doors'] ?? $this->can_open_doors;
        $this->can_pass_doors = $values['can_pass_doors'] ?? $this->can_pass_doors;
    }
}