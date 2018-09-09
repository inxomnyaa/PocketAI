<?php

declare(strict_types=1);

namespace xenialdan\PocketAI\component;

use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

interface BaseComponent
{

    /**
     * BaseComponent constructor.
     * @param string $name
     * @param $data
     * /
    public function __construct(string $name, $data);*/

    /**
     * Applies the changes to the mob
     * @param AIEntity|AIProjectile $entity
     */
    public function apply($entity): void;

    /**
     * Removes the changes from the mob
     * @param AIEntity|AIProjectile $entity
     */
    public function remove($entity): void;
}