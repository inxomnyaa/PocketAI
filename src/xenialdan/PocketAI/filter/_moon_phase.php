<?php

namespace xenialdan\PocketAI\filter;

use pocketmine\entity\Entity;
use xenialdan\PocketAI\entitytype\AIEntity;

class _moon_phase extends BaseFilter
{
    protected $name = "moon_phase";
    /** @var string $operator (Optional) The comparison to apply with 'value'. */
    public $operator = "equals";
    /** @var string $subject (Optional) The subject of this filter test. */
    public $subject = "self";
    /** @var int $value (Required) An integer value. */
    public $value;

    /**
     * Compares the current moon phase with an integer value in the range (0, 7).
     * _moon_phase constructor.
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