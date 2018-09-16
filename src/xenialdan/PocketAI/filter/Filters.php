<?php

namespace xenialdan\PocketAI\filter;

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
class Filters extends \SplDoublyLinkedList
{

    public function push($value)
    {
        if (!$value instanceof BaseFilter)
            throw new \InvalidArgumentException("Value must be a filter");
        parent::push($value);
    }

    public function add($index, $newval)
    {
        if (!$newval instanceof BaseFilter)
            throw new \InvalidArgumentException("Value must be a filter");
        parent::add($index, $newval);
    }

    public function offsetSet($index, $newval)
    {
        if (!$newval instanceof BaseFilter)
            throw new \InvalidArgumentException("Value must be a filter");
        parent::offsetSet($index, $newval);
    }

}