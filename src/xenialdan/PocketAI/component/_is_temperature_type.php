<?php

namespace xenialdan\PocketAI\component;

use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _is_temperature_type extends BaseComponent
{
    protected $name = "is_temperature_type";
    /** @var string $operator (Optional) The comparison to apply with 'value'. */
    public $operator = "equals";
    /** @var string $subject (Optional) The subject of this filter test. */
    public $subject = "self";
    /** @var string $value (Required) The Biome temperature catagory to test
     * : { */
            public $value;
            /** @var mixed $ }
             * ;Examples
             *
             * : Full..
             *
             * : { "test": "is_temperature_type", "subject": "self", "operator": "equals", "value": "cold" }
             *
             * : Short (using Defaults)..
             *
             * : { "test": "is_temperature_type", "value": "cold" */
            public $ = }

;


/**
 * Tests whether the current temperature is a given type.
 * _is_temperature_type constructor.
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
