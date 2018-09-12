<?php

namespace xenialdan\PocketAI\component;

use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _has_equipment extends BaseComponent
{
    protected $name = "has_equipment";
    /** @var string $domain (Optional) The equipment location to test
     * : { */
            public $domain = "any";
            /** @var mixed $ */
            public $ = }

;
/** @var string $operator (Optional) The comparison to apply with 'value'. */
public
$operator = "equals";
/** @var string $subject (Optional) The subject of this filter test. */
public
$subject = "self";
/** @var string $value (Required) The item name to look for */
public
$value;


/**
 * Tests for the presence of a named item in the designated slot of the subject entity.
 * _has_equipment constructor.
 * @param array $values
 */
public
function __construct(array $values = [])
{
    $this->domain = $values['domain'] ?? $this->domain;
    $this-> = $values[''] ?? $this->;
    $this->operator = $values['operator'] ?? $this->operator;
    $this->subject = $values['subject'] ?? $this->subject;
    $this->value = $values['value'] ?? $this->value;

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
