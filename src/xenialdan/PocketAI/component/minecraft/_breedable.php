<?php

namespace xenialdan\PocketAI\component\minecraft;

use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;
use xenialdan\PocketAI\event\CallableEvent;

class _breedable extends BaseComponent
{
    protected $name = "minecraft:breedable";
    /** @var bool $allowSitting If true, entities can breed while sitting */
    public $allowSitting = false;
    /** @var float $breedCooldown Time in seconds before the Entity can breed again */
    public $breedCooldown = 60.0;
    /** @var array $breedItems The list of items that can be used to get the entity into the 'love' state */
    public $breedItems;
    /** @var array $breedsWith The list of entity definitions that this entity can breed with
     * ;Parameters
     *
     */
    public $breedsWith;
    /** @var string $babyType The entity definition of this entity's babies */
    public $babyType;
    /** @var CallableEvent $breed_event Event to run when this entity breeds */
    public $breed_event;
    /** @var string $mateType The entity definition of this entity's mate */
    public $mateType;
    /** @var float $extraBabyChance Chance that up to 16 babies will spawn between 0.0 and 1.0, where 1.0 is 100% */
    public $extraBabyChance = 0.0;
    /** @var bool $inheritTamed If true, the babies will be automatically tamed if its parents are */
    public $inheritTamed = true;
    /** @var mixed (JSON Object) $mutation_factor Determines how likely the babies are to NOT inherit one of their parent's variances. Values are between 0.0 and 1.0, with a higher number meaning more likely to mutate
     * ;Parameters
     *
     */
    public $mutation_factor;
    /** @var float $color The percentage chance of a mutation on the entity's color */
    public $color = 0.0;
    /** @var float $extra_variant The percentage chance of a mutation on the entity's extra variant type */
    public $extra_variant = 0.0;
    /** @var float $variant The percentage chance of a mutation on the entity's variant type */
    public $variant = 0.0;
    /** @var bool $requireTame If true, the entities need to be tamed first before they can breed. */
    public $requireTame = true;

    /**
     * Defines the way an entity can get into the 'love' state.
     * _breedable constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->allowSitting = $values['allowSitting'] ?? $this->allowSitting;
        $this->breedCooldown = $values['breedCooldown'] ?? $this->breedCooldown;
        $this->breedItems = $values['breedItems'] ?? $this->breedItems;
        $this->breedsWith = $values['breedsWith'] ?? $this->breedsWith;
        $this->babyType = $values['babyType'] ?? $this->babyType;
        $this->breed_event = new CallableEvent($values['breed_event'] ?? []);
        $this->mateType = $values['mateType'] ?? $this->mateType;
        $this->extraBabyChance = $values['extraBabyChance'] ?? $this->extraBabyChance;
        $this->inheritTamed = $values['inheritTamed'] ?? $this->inheritTamed;
        $this->mutation_factor = $values['mutation_factor'] ?? $this->mutation_factor;
        $this->color = $values['color'] ?? $this->color;
        $this->extra_variant = $values['extra_variant'] ?? $this->extra_variant;
        $this->variant = $values['variant'] ?? $this->variant;
        $this->requireTame = $values['requireTame'] ?? $this->requireTame;

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
