<?php

namespace xenialdan\PocketAI\filter;

use pocketmine\entity\Entity;
use xenialdan\PocketAI\entitytype\AIEntity;

class _clock_time extends BaseFilter
{
    protected $name = "clock_time";
    /** @var string $operator (Optional) The comparison to apply with 'value'. */
    public $operator = "equals";
    /** @var string $subject (Optional) The subject of this filter test. */
    public $subject = "self";
    /** @var float $value (Required) A floating point value. */
    public $value;

    /**
     * Compares the current time with a float value in the range (0.0, 1.0).
     * _clock_time constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->operator = $values['operator'] ?? $this->operator;
        $this->subject = $values['subject'] ?? $this->subject;
        $this->value = $values['value'] ?? $this->value;

    }

    public function test(AIEntity $caller, Entity $other): bool
    {
        $return = parent::test($caller, $other);
        if (!$return) return $return;
        // TODO: Implement test() method.
        return false;
    }
}