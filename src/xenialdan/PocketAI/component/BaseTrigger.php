<?php

namespace xenialdan\PocketAI\component;

use pocketmine\entity\Entity;
use pocketmine\Player;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

abstract class BaseTrigger extends BaseComponent
{
    /** @var string $event The event to run when the conditions for this trigger are met */
    public $event;
    /** @var string (Minecraft Filter) $filters The list of conditions for this trigger */
    public $filters;
    /** @var string $target The target of the event */
    public $target = "self";

    /** @var Entity|null */
    public $targetToUse = null;

    /**
     * BaseTrigger constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->event = $values['event'] ?? $this->event;
        $this->filters = $values['filters'] ?? $this->filters;
        $this->target = $values['target'] ?? $this->target;
    }

    /**
     * @param AIEntity $caller Entity calling the test
     * @param Entity $other Entity involved in the interaction
     * @return bool
     */
    public function trigger(AIEntity $caller, Entity $other): bool{
        $toUse = $this->targetToTest($caller, $other);
        if(is_null($toUse)) return false;
        $this->targetToUse = $toUse;
        return true;
    }

    /**
     * Returns the subject that the test should run on
     * @param AIEntity $caller
     * @param Entity $other
     * @return null|Entity
     */
    public function targetToTest(AIEntity $caller, Entity $other) :?Entity{
        switch ($this->target){
            //The other member of an interaction, not the caller
            case "other":{
                return $other;
                break;
            }
            //The caller's current parent
            case "parent":{
                return $caller->getParentEntity();
                break;
            }
            //TODO The player involved with the interaction --Could possibly be even another entity?
            case "player":{
                return ($other instanceof Player)?$other:null;
                break;
            }
            //The entity or object calling the test
            case "self":{
                return $caller;
                break;
            }
            //The caller's current target
            case "target":{
                return $caller->getTargetEntity();
                break;
            }
        }
        return null;
    }

    /**
     * Applies the changes to the mob
     * @param AIEntity|AIProjectile $entity
     */
    public function apply($entity): void{}

    /**
     * Removes the changes from the mob
     * @param AIEntity|AIProjectile $entity
     */
    public function remove($entity): void{}
}