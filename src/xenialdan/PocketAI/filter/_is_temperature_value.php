<?php

namespace xenialdan\PocketAI\filter;

use pocketmine\entity\Entity;
use xenialdan\PocketAI\entitytype\AIEntity;

class _is_temperature_value extends BaseFilter
{
    protected $name = "is_temperature_value";
    /** @var string $operator (Optional) The comparison to apply with 'value'. */
    public $operator = "equals";
    /** @var string $subject (Optional) The subject of this filter test. */
    public $subject = "self";
    /** @var float $value (Required) The Biome temperature value to compare with. */
    public $value;

    /**
     * Tests the current temperature against a provided value in the range (0.0, 1.0) where 0.0f is the coldest temp and 1.0f is the hottest.
     * _is_temperature_value constructor.
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