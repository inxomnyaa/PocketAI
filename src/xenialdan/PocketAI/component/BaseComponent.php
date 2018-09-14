<?php

declare(strict_types=1);

namespace xenialdan\PocketAI\component;

use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

abstract class BaseComponent
{
    protected $name;

    /**
     * BaseComponent constructor.
     * @param array $values
     */
    public abstract function __construct(array $values = []);

    /**
     * Applies the changes to the mob
     * @param AIEntity|AIProjectile $entity
     */
    public abstract function apply($entity): void;

    /**
     * Removes the changes from the mob
     * @param AIEntity|AIProjectile $entity
     */
    public abstract function remove($entity): void;

    public function getName(): string
    {
        return $this->name;
    }
}