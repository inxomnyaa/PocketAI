<?php

namespace xenialdan\PocketAI\component;

class _has_damage extends BaseTest
{
    protected $name = "has_damage";
    /** @var string $operator (Optional) The comparison to apply with 'value'. */
    public $operator = "equals";
    /** @var string $subject (Optional) The subject of this filter test. */
    public $subject = "self";
    /** @var string $value (Required) The Damage type to test
     */
    public $value;


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

    }

    public function test(): bool
    {
        // TODO: Implement test() method.
        return false;
    }
}