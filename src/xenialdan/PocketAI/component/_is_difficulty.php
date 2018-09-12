<?php

namespace xenialdan\PocketAI\component;

use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _is_difficulty extends BaseComponent
{
    protected $name = "is_difficulty";
    /** @var string $operator (Optional) The comparison to apply with 'value'. */
    public $operator = "equals";
    /** @var string $subject (Optional) The subject of this filter test. */
    public $subject = "self";
    /** @var string $value (Required) The game's difficulty level to test
     * : { */
            public $value;
            /** @var mixed $ }
             * ;Examples
             *
             * : Full..
             *
             * : { "test": "is_difficulty", "subject": "self", "operator": "equals", "value": "normal" }
             *
             * : Short (using Defaults)..
             *
             * : { "test": "is_difficulty", "value": "normal" */
            public $ = }

;


/**
 * Tests the current difficulty level of the game.
 * _is_difficulty constructor.
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
