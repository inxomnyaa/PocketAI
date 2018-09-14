<?php

namespace xenialdan\PocketAI\component;

class Components extends \SplDoublyLinkedList
{

    public function push($value)
    {
        if (!$value instanceof BaseComponent)
            throw new \InvalidArgumentException("Value must be a component");
        parent::push($value);
    }

    public function add($index, $newval)
    {
        if (!$newval instanceof BaseComponent)
            throw new \InvalidArgumentException("Value must be a component");
        parent::add($index, $newval);
    }

    public function offsetSet($index, $newval)
    {
        if (!$newval instanceof BaseComponent)
            throw new \InvalidArgumentException("Value must be a component");
        parent::offsetSet($index, $newval);
    }

}