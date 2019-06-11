<?php

namespace xenialdan\PocketAI\ai;

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

    /**
     * AIManager constructor.
     * @param AIEntity $entity
     */
    public function __construct(AIEntity $entity)
    {
        $this->update($entity->getEntityProperties());
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