<?php

namespace xenialdan\PocketAI\component;

use pocketmine\entity\Entity;
use xenialdan\PocketAI\entitytype\AIEntity;

class _is_difficulty extends BaseTest
{
    protected $name = "is_difficulty";
    /** @var string $operator (Optional) The comparison to apply with 'value'. */
    public $operator = "equals";
    /** @var string $subject (Optional) The subject of this filter test. */
    public $subject = "self";
    /** @var string $value (Required) The game's difficulty level to test */
    public $value;

    /**
     * Tests the current difficulty level of the game.
     * _is_difficulty constructor.
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