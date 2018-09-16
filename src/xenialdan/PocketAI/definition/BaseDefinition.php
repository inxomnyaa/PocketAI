<?php

declare(strict_types=1);

namespace xenialdan\PocketAI\definition;

use pocketmine\entity\Entity;

abstract class BaseDefinition
{
    /** @var string Name of this definition */
    protected $name;
    /** @var mixed $value (Required) The value to test */
    public $value;

    /** @var Entity|null */
    public $subjectToTest = null;

    /**
     * BaseComponent constructor.
     * @param array $values
     */
    public abstract function __construct(array $values = []);

    /**
     * @return string Name of this test
     */
    public function getName(): string
    {
        return $this->name;
    }
}