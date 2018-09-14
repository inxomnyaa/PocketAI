<?php

namespace xenialdan\PocketAI\component;

use pocketmine\entity\Entity;

class _is_temperature_type extends BaseTest
{
    protected $name = "is_temperature_type";
    /** @var string $operator (Optional) The comparison to apply with 'value'. */
    public $operator = "equals";
    /** @var string $subject (Optional) The subject of this filter test. */
    public $subject = "self";
    /** @var string $value (Required) The Biome temperature catagory to test */
    public $value;

    /**
     * Tests whether the current temperature is a given type.
     * _is_temperature_type constructor.
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