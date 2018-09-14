<?php

namespace xenialdan\PocketAI\component;

use pocketmine\entity\Entity;

class _is_variant extends BaseTest
{
    protected $name = "is_variant";
    /** @var string $operator (Optional) The comparison to apply with 'value'. */
    public $operator = "equals";
    /** @var string $subject (Optional) The subject of this filter test. */
    public $subject = "self";
    /** @var int $value (Required) An integer value. */
    public $value;

    /**
     * Returns true if the subject entity is the variant number provided.
     * _is_variant constructor.
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