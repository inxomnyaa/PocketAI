<?php

namespace xenialdan\PocketAI\definition;

/**
 * Class Definitions
 * @package xenialdan\PocketAI\definition
 */
class Definitions extends \SplDoublyLinkedList
{

    public function push($value)
    {
        if (!$value instanceof BaseDefinition)
            throw new \InvalidArgumentException("Value must be a definition");
        parent::push($value);
    }

    public function add($index, $newval)
    {
        if (!$newval instanceof BaseDefinition)
            throw new \InvalidArgumentException("Value must be a definition");
        parent::add($index, $newval);
    }

    public function offsetSet($index, $newval)
    {
        if (!$newval instanceof BaseDefinition)
            throw new \InvalidArgumentException("Value must be a definition");
        parent::offsetSet($index, $newval);
    }

}