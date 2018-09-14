<?php

namespace xenialdan\PocketAI;

use pocketmine\inventory\InventoryHolder;
use pocketmine\plugin\PluginException;
use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\component\ComponentGroup;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class EntityProperties
{
    /** @var string */
    private $behaviourName = "empty";
    /** @var \SplQueue|null */
    private $components;
    /** @var \SplQueue */
    public $componentGroups;
    /** @var null|AIEntity|AIProjectile|InventoryHolder */
    private $entity;

    /**
     * EntityProperties constructor.
     * @param string $behaviourName
     * @param AIEntity|AIProjectile $entity
     */
    public function __construct(string $behaviourName, $entity)
    {
        if (is_null($entity)) {
            throw new PluginException("Can not initialize EntityProperties because no / an invalid null entity was given");
        }
        if (!$entity instanceof AIEntity && !$entity instanceof AIProjectile) {
            throw new PluginException("Can not initialize EntityProperties for class of type: " . get_class($entity));
        }
        if (!array_key_exists($behaviourName, Loader::$components)) throw new \InvalidArgumentException("Entity behaviour/properties file: " . $behaviourName . " not found for entity of type " . $entity->getName());

        $this->behaviourName = $behaviourName;
        $this->components = Loader::$components[$this->behaviourName];
        $this->componentGroups = Loader::$component_groups[$this->behaviourName];
        $this->entity = $entity;
    }

    public function applyComponents(): void
    {
        /** @var BaseComponent $component */
        foreach ($this->components as $component) {
            $component->apply($this->entity);
        }
    }

    public function removeComponents(): void
    {
        /** @var BaseComponent $component */
        foreach ($this->components as $component) {
            $component->remove($this->entity);
        }
    }

    /**
     * @return string
     */
    public function getBehaviourName(): string
    {
        return $this->behaviourName;
    }

    /**
     * @return array[\SplQueue]
     */
    public function getComponents(): array
    {
        return array_flip(iterator_to_array($this->components));
    }

    /**
     * @return array[ComponentGroup]
     */
    public function getComponentGroups(): array
    {
        return array_flip(iterator_to_array($this->componentGroups));
    }

    public function findComponentGroup(string $group): ?ComponentGroup
    {//TODO
        $map = array_filter($this->componentGroups, function ($v) use ($group) {
            /** @var ComponentGroup $v */
            return $v->name === $group;
        });
        if (empty($map)) return null; else return $map[0];
    }

    //TODO use SplQueue? TODO Move to Loader?
    public function getEvents(): array
    {
        return Loader::$events[$this->getBehaviourName()] ?? [];
    }

    public function getEvent(string $event): array
    {
        $data = $this->getEvents()[$event] ?? [];
        if (empty($data)) Loader::getInstance()->getLogger()->alert("An AddonEvent was called, but no such definition was found: " . $event . " in " . $this->getBehaviourName());
    }
}