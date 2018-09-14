<?php

declare(strict_types=1);

namespace xenialdan\PocketAI\component;

use pocketmine\entity\Entity;

abstract class BaseTest
{
    protected $name;
    /** @var string $operator (Optional) The comparison to apply with 'value'. */
    public $operator = "equals";
    /** @var string $subject (Optional) The subject of this filter test. */
    public $subject = "self";
    /** @var mixed $value (Required) The value to test */
    public $value;

    /**
     * BaseComponent constructor.
     * @param array $values
     */
    public abstract function __construct(array $values = []);

    public abstract function test(Entity $self, Entity $other): bool;

    public function getName(): string
    {
        return $this->name;
    }
}