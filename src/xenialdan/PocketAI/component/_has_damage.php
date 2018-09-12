<?php

namespace xenialdan\PocketAI\component;

use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _has_damage extends BaseComponent
{
    protected $name = "has_damage";
    /** @var string $operator (Optional) The comparison to apply with 'value'. */
    public $operator = "equals";
    /** @var string $subject (Optional) The subject of this filter test. */
    public $subject = "self";
    /** @var string $value (Required) The Damage type to test
     * : { */
            public $value;
            /** @var mixed $ }
             * ;Examples
             *
             * : Full..
             *
             * : { "test": "has_damage", "subject": "self", "operator": "equals", "value": "fatal" }
             *
             * : Short (using Defaults)..
             *
             * : { "test": "has_damage", "value": "fatal" */
            public $ = }

;
/** @var mixed $Any damage which kills the subject */
public
$Any damage which kills the subject;
            

    /**
     * Returns true when the subject entity receives the named damage type.
     * _has_damage constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
{
    $this->operator = $values['operator'] ?? $this->operator;
    $this->subject = $values['subject'] ?? $this->subject;
    $this->value = $values['value'] ?? $this->value;
    $this-> = $values[''] ?? $this->;
    $this->Any damage which kills the subject = $values['Any damage which kills the subject'] ?? $this->Any damage which kills the subject;
            
    }

    /**
     * Applies the changes to the mob
     * @param AIEntity|AIProjectile $entity
     */
    public function apply($entity): void
{
    // TODO: Implement apply() method.
}

    /**
     * Removes the changes from the mob
     * @param AIEntity|AIProjectile $entity
     */
    public function remove($entity): void
{
    // TODO: Implement remove() method.
}
}
