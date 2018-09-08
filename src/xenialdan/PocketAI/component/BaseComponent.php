<?php

declare(strict_types=1);

namespace xenialdan\PocketAI\component;

use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class BaseComponent
{

    public $name = "Unknown";
    public $data = [];

    /**
     * BaseComponent constructor.
     * @param string $name
     * @param array $data
     */
    public function __construct(string $name, array $data = [])
    {
        $this->name = $name;
        $this->data = $data;
    }

    /**
     * Applies the changes to the mob
     * @param AIEntity|AIProjectile $entity
     */
    public function apply($entity): void
    {
    }

    /**
     * Removes the changes from the mob
     * @param AIEntity|AIProjectile $entity
     */
    public function remove($entity): void
    {
    }
}