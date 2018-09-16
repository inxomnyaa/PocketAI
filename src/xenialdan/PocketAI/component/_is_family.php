<?php

namespace xenialdan\PocketAI\component;

use pocketmine\entity\Entity;

class _is_family extends BaseTest
{
    protected $name = "is_family";
    /** @var string $operator (Optional) The comparison to apply with 'value'. */
    public $operator = "equals";
    /** @var string $subject (Optional) The subject of this filter test. */
    public $subject = "self";
    /** @var string $value (Required) The Family name to look for */
    public $value;

    /**
     * Returns true when the subject entity is a member of the named family.
     * _is_family constructor.
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
        //TODO undo!
        return true;
        // TODO: Implement test() method.
        return false;
    }
}