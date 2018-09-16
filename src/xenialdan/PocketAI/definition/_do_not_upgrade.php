<?php

namespace xenialdan\PocketAI\definition;

class _do_not_upgrade extends BaseDefinition
{
    protected $name = "do_not_upgrade";

    /**
     * Disables all current and future backwards compatibility for this entity. If new components or properties are added or changed to the vanilla version of this entity, they will not be applied.
     * _do_not_upgrade constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {

    }
}
