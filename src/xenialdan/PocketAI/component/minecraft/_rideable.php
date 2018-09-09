
<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class _rideable implements BaseComponent
{
    protected $name = "minecraft:rideable";
    private $priority;private $seat_count;private $family_types;private $interact_text;private $seats;

    public function __construct(string $name, $priority,$seat_count,$family_types,$interact_text,$seats)
    {
        $this->priority = priority;$this->seat_count = seat_count;$this->family_types = family_types;$this->interact_text = interact_text;$this->seats = seats;
    }

    /**
     * Applies the changes to the mob
     * @param AIEntity|AIProjectile $entity
     */
    public function apply($entity): void
    {
        // TODO: Implement apply() method.
    }

    /**
     * Removes the changes from the mob
     * @param AIEntity|AIProjectile $entity
     */
    public function remove($entity): void
    {
        // TODO: Implement remove() method.
    }
}
