<?php

declare(strict_types=1);

namespace xenialdan\PocketAI\component;

use pocketmine\entity\Entity;
use pocketmine\Player;
use xenialdan\PocketAI\entitytype\AIEntity;

abstract class BaseTest
{
    /** @var string Name of this test */
    protected $name;
    /** @var string $operator (Optional) The comparison to apply with 'value'. */
    public $operator = "equals";
    /** @var string $subject (Optional) The subject of this filter test. */
    public $subject = "self";
    /** @var mixed $value (Required) The value to test */
    public $value;

    /** @var Entity|null */
    public $subjectToTest = null;

    /**
     * BaseComponent constructor.
     * @param array $values
     */
    public abstract function __construct(array $values = []);

    /*
     * @param Entity $caller Entity calling the test
     * @param Entity $other Entity involved in the interaction
     * @return bool
     *
    public abstract function test(Entity $caller, Entity $other): bool;*/

    /**
     * @param AIEntity $caller Entity calling the test
     * @param Entity $other Entity involved in the interaction
     * @return bool
     */
    public function test(AIEntity $caller, Entity $other): bool{
        $toTest = $this->subjectToTest($caller, $other);
        if(is_null($toTest)) return false;
        $this->subjectToTest = $toTest;
        return true;
    }

    /**
     * @return string Name of this test
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns the subject that the test should run on
     * @param AIEntity $caller
     * @param Entity $other
     * @return null|Entity
     */
    public function subjectToTest(AIEntity $caller, Entity $other) :?Entity{
        switch ($this->subject){
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
     * Compares 2 values with each other
     * @param $val1
     * @param $val2
     * @return bool
     */
    public function compare($val1, $val2) : bool{
        switch ($this->operator){
            //Test for equality
            case "=":{
                return $val1 == $val2;
                break;
            }
            //Test for equality
            case "==":
            //Test for equality
            case "equals":{
                return $val1 === $val2;
                break;
            }
            //Test for inequality
            case "not":
            //Test for inequality
            case "!=":{
                return $val1 != $val2;
                break;
            }
            //Test for less-than the value
            case "<":{
                return $val1 < $val2;
                break;
            }
            //Test for less-than or equal to the value
            case "<=":{
                return $val1 <= $val2;
                break;
            }
            //Test for inequality
            case "<>":{
                return $val1 <> $val2;
                break;
            }
            //Test for greater-than the value
            case ">":{
                return $val1 > $val2;
                break;
            }
            //Test for greater-than or equal to the value
            case ">=":{
                return $val1 !== $val2;
                break;
            }
        }
        return false;
    }
}