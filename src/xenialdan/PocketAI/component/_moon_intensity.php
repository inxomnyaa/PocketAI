<?php

namespace xenialdan\PocketAI\component;

class _moon_intensity extends BaseTest
{
    protected $name = "moon_intensity";
    /** @var string $operator (Optional) The comparison to apply with 'value'. */
    public $operator = "equals";
    /** @var string $subject (Optional) The subject of this filter test. */
    public $subject = "self";
    /** @var float $value (Required) A floating point value. */
    public $value;


    /**
     * Compares the current moon intensity with a float value in the range (0.0, 1.0)
     * _moon_intensity constructor.
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