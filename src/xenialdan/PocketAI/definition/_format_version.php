<?php

namespace xenialdan\PocketAI\definition;

class _format_version extends BaseDefinition
{
    protected $name = "format_version";

    /**
     * Specifies the version of the game this entity was made in. If the version is lower than the current version, any changes made to the entity in the vanilla version will be applied to it.
     * _format_version constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {

    }
}
