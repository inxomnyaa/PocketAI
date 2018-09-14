<?php

namespace xenialdan\PocketAI\component;

use pocketmine\entity\Entity;

class _has_equipment extends BaseTest
{
    protected $name = "has_equipment";
    /** @var string $domain (Optional) The equipment location to test */
    public $domain = "any";
    /** @var string $operator (Optional) The comparison to apply with 'value'. */
    public $operator = "equals";
    /** @var string $subject (Optional) The subject of this filter test. */
    public $subject = "self";
    /** @var string $value (Required) The item name to look for */
    public $value;

    /**
     * Tests for the presence of a named item in the designated slot of the subject entity.
     * _has_equipment constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->domain = $values['domain'] ?? $this->domain;
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