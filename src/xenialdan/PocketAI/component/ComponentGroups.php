<?php

namespace xenialdan\PocketAI\component;

class ComponentGroups extends \SplDoublyLinkedList
{

    public function push($value)
    {
        if (!$value instanceof ComponentGroup)
            throw new \InvalidArgumentException("Value must be a component group");
        parent::push($value);
    }

    public function add($index, $newval)
    {
        if (!$newval instanceof ComponentGroup)
            throw new \InvalidArgumentException("Value must be a component group");
        parent::add($index, $newval);
    }

    public function offsetSet($index, $newval)
    {
        if (!$newval instanceof ComponentGroup)
            throw new \InvalidArgumentException("Value must be a component group");
        parent::offsetSet($index, $newval);
    }

}