<?php

namespace xenialdan\PocketAI\component;

class _in_water extends BaseTest
{
    protected $name = "in_water";
    /** @var string $operator (Optional) The comparison to apply with 'value'. */
    public $operator = "equals";
    /** @var string $subject (Optional) The subject of this filter test. */
    public $subject = "self";
    /** @var bool $value (Optional) true or false. */
    public $value = true;


    /**
     * Returns true when the subject entity is in water.
     * _in_water constructor.
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