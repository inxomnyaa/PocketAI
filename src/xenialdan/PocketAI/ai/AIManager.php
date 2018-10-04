<?php

namespace xenialdan\PocketAI\ai;

use xenialdan\astar3d\Grid;
use xenialdan\astar3d\Pathfinder;
use xenialdan\PocketAI\component\minecraft\behavior\BehaviourComponent;
use xenialdan\PocketAI\component\minecraft\behavior\MovementComponent;
use xenialdan\PocketAI\component\minecraft\behavior\NavigationComponent;
use xenialdan\PocketAI\EntityProperties;

class AIManager
{

    /** @var \SplQueue */
    public $navigators;
    /** @var \SplQueue */
    public $movements;
    /** @var \SplPriorityQueue */
    public $behaviours;
    /** @var Pathfinder */
    public $pathfinder;
    /** @var Grid */
    public $navigationGrid;

    /**
     * AIManager constructor.
     * @param EntityProperties $entityProperties
     */
    public function __construct(EntityProperties &$entityProperties)
    {
        $this->navigators = new \SplQueue();
        $this->movements = new \SplQueue();
        $this->behaviours = new \SplPriorityQueue();

        foreach ($entityProperties->getComponentsArray() as $component){
            if($component instanceof MovementComponent){
                $this->movements->push($component);
                continue;
            }
            if($component instanceof NavigationComponent){
                $this->navigators->push($component);
                continue;
            }
            if($component instanceof BehaviourComponent){
                $this->behaviours->insert($component, $component->priority);
                continue;
            }
        }
        $this->behaviours->top();

        var_dump(iterator_to_array($this->navigators));
        var_dump(iterator_to_array($this->movements));
        var_dump(iterator_to_array($this->behaviours));
    }
}