<?php

namespace xenialdan\PocketAI\filter;

use pocketmine\entity\Entity;
use xenialdan\PocketAI\entitytype\AIEntity;

/**
 * Class Filters
 * @inheritdoc
 * Filters allow data objects to specify test criteria which allows their use.
 * For example, a model that includes a filter will only be used when the filter criteria is true.
 * A typical filter consists of four parameters:
 * name: the name of the test to apply.
 * domain: the domain the test should be performed in. An armor slot, for example. This parameter is only used by a few tests.
 * operator: the comparison to apply with the value, such as 'equal' or 'greater'.
 * value: the value being compared with the test.
 * A typical filter looks like the following:
 * { "test" : "moon_intensity", "subject" : "self", "operator" : "greater", "value" : "0.5" }
 * Which results in the calling entity (self) calculating the moon_intensity at its location and returning true if the result is greater than 0.5.
 * Tests can be combined into groups using the collections 'all_of' and 'any_of'.
 * All tests in an 'all_of' group must pass in order for the group to pass.
 * One or more tests in an 'any_of' group must pass in order for the group to pass.
 * Example:
 * "all_of" : [
 *   { "test" : "moon_intensity", "subject" : "self", "operator" : "greater", "value" : "0.5" },
 *   { "test" : "in_water", "subject" : "target", "operator" : "equal", "value" : "true" }
 * ]
 * This filter group will pass only when the moon_intensity is greater than 0.5 AND the caller's target entity is standing in water.
 *
 * @package xenialdan\PocketAI\filter
 */
class Filters//TODO rename to FilterGroup? (if multiple groups are definable - i.e. ["all_of"[...],"any_of"[...]])
{
    /** @var \SplDoublyLinkedList[BaseFilter] */
    public $filters;
    /** @var string "all_of" or "any_of" */
    public $groupType;

    /**
     * Filters constructor.
     * @param array $filters
     */
    public function __construct(array $filters)//TODO check if issues occur if multiple groups are defined - i.e. ["all_of"[...],"any_of"[...]]
    {
        $this->filters = new \SplDoublyLinkedList();
        foreach ($filters as $groupType => $filter){
            $this->groupType = $groupType;
            foreach ($filter as $value){
                $class = "xenialdan\\PocketAI\\filter\\_" . $value["test"];
                if (class_exists($class)) {
                    /** @var BaseFilter $testclass */
                    $testclass = new $class($value);
                    $this->push($testclass);
                }
            }
        }
    }

    /**
     * @param AIEntity $caller Entity calling the test
     * @param Entity $other Entity involved in the interaction
     * @return bool
     */
    public function test(AIEntity $caller, Entity $other): bool{
        $filtered = array_filter(iterator_to_array($this->filters), function ($filter) use ($caller, $other){
            /** @var BaseFilter $filter */
            return $filter->test($caller, $other);
        });
        return (($this->groupType === "any_of" && !empty($filtered)) xor ($this->groupType === "all_of" && count($filtered) === $this->filters->count()));
    }


    public function push($value)
    {
        if (!$value instanceof BaseFilter)
            throw new \InvalidArgumentException("Value must be a filter");
        $this->filters->push($value);
    }

    public function add($index, $newval)
    {
        if (!$newval instanceof BaseFilter)
            throw new \InvalidArgumentException("Value must be a filter");
        $this->filters->add($index, $newval);
    }

    public function offsetSet($index, $newval)
    {
        if (!$newval instanceof BaseFilter)
            throw new \InvalidArgumentException("Value must be a filter");
        $this->filters->offsetSet($index, $newval);
    }

}