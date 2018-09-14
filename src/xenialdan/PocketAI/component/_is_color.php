<?php

namespace xenialdan\PocketAI\component;

use pocketmine\entity\Entity;

class _is_color extends BaseTest
{
    protected $name = "is_color";
    /** @var string $operator (Optional) The comparison to apply with 'value'. */
    public $operator = "equals";
    /** @var string $subject (Optional) The subject of this filter test. */
    public $subject = "self";
    /** @var string $value (Required) The Palette Color to test */
    public $value;

    /**
     * Returns true if the subject entity is the named color.
     * _is_color constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->operator = $values['operator'] ?? $this->operator;
        $this->subject = $values['subject'] ?? $this->subject;
        $this->value = $values['value'] ?? $this->value;

    }

    public function test(Entity $self, Entity $other): bool
    {
        // TODO: Implement test() method.
        return false;
    }
}