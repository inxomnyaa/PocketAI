<?php

namespace xenialdan\PocketAI\component;

use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _is_biome extends BaseComponent
{
    protected $name = "is_biome";
    /** @var string $operator (Optional) The comparison to apply with 'value'. */
    public $operator = "equals";
    /** @var string $subject (Optional) The subject of this filter test. */
    public $subject = "self";
    /** @var string $value (Required) The Biome type to test
     * : { */
            public $value;
            /** @var mixed $ }
             * ;Examples
             *
             * : Full..
             *
             * : { "test": "is_biome", "subject": "self", "operator": "equals", "value": "beach" }
             *
             * : Short (using Defaults)..
             *
             * : { "test": "is_biome", "value": "beach" */
            public $ = }

;


/**
 * Tests whether the Subject is currently in the named biome.
 * _is_biome constructor.
 * @param array $values
 */
public
function __construct(array $values = [])
{
    $this->operator = $values['operator'] ?? $this->operator;
    $this->subject = $values['subject'] ?? $this->subject;
    $this->value = $values['value'] ?? $this->value;
    $this-> = $values[''] ?? $this->;

}

/**
 * Applies the changes to the mob
 * @param AIEntity|AIProjectile $entity
 */
public
function apply($entity): void
{
    // TODO: Implement apply() method.
}

/**
 * Removes the changes from the mob
 * @param AIEntity|AIProjectile $entity
 */
public
function remove($entity): void
{
    // TODO: Implement remove() method.
}
}
