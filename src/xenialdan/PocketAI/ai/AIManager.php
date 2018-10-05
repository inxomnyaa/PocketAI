<?php

namespace xenialdan\PocketAI\ai;

use pocketmine\block\BlockIds;
use pocketmine\entity\Entity;
use xenialdan\astar3d\Grid;
use xenialdan\astar3d\Pathfinder;
use xenialdan\astar3d\SurfaceType;
use xenialdan\astar3d\TestingMode;
use xenialdan\PocketAI\component\minecraft\behavior\BehaviourComponent;
use xenialdan\PocketAI\component\minecraft\movement\MovementComponent;
use xenialdan\PocketAI\component\minecraft\navigation\NavigationComponent;
use xenialdan\PocketAI\EntityProperties;
use xenialdan\PocketAI\entitytype\AIEntity;

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
     * @param AIEntity $entity
     */
    public function __construct(AIEntity $entity)
    {
        $this->update($entity->getEntityProperties());
        $this->pathfinder = new Pathfinder();
        $this->pathfinder->grid = new Grid();
        $this->pathfinder->grid->Base = $entity;
        $this->pathfinder->grid->nodeRadius = $entity->getWidth()/2;
        $this->pathfinder->grid->testingMode = TestingMode::SWEEPTESTING;
        $surfaceType = new SurfaceType();
        $surfaceType->layerMask = BlockIds::GRASS;
        $surfaceType->penalty = 0;
        $this->pathfinder->grid->walkableRegions[] = $surfaceType;
    }

    /**
     * Updates all fields.. maybe this is the shittiest thing ever to do..
     * Maybe change this to be done by apply() and remove() directly inside the components instead?
     * @param EntityProperties $entityProperties
     */
    public function update(EntityProperties $entityProperties){
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
                $this->behaviours->insert($component, PHP_INT_MAX - $component->priority);
                continue;
            }
        }
        $this->behaviours->top();

        var_dump(iterator_to_array($this->navigators));
        var_dump(iterator_to_array($this->movements));
        var_dump(iterator_to_array($this->behaviours));
    }
}