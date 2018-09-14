<?php

namespace xenialdan\PocketAI;

use pocketmine\inventory\InventoryHolder;
use pocketmine\plugin\PluginException;
use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\component\ComponentGroup;
use xenialdan\PocketAI\component\ComponentGroups;
use xenialdan\PocketAI\component\Components;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class EntityProperties
{
    /** @var string */
    private $behaviourName = "empty";
    /** @var Components */
    private $components;
    /** @var ComponentGroups */
    public $componentGroups;
    /** @var ComponentGroups */
    public $activeComponentGroups;
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
        $this->activeComponentGroups = new ComponentGroups();
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
        return iterator_to_array($this->components);
    }

    public function findComponent(string $name): ?BaseComponent
    {
        $map = array_values(array_filter($this->getComponents(), function ($v) use ($name) {
            /** @var BaseComponent $v */
            return $v->getName() === $name;
        }));
        if (!empty($map)) return $map[0];
        return null;
    }

    /**
     * @return array[ComponentGroup]
     */
    public function getComponentGroups(): array
    {
        return iterator_to_array($this->componentGroups);
    }

    public function findComponentGroup(string $name): ComponentGroup
    {
        $map = array_values(array_filter($this->getComponentGroups(), function ($v) use ($name) {
            /** @var ComponentGroup $v */
            return $v->name === $name;
        }));
        if (!empty($map)) return $map[0];
        else throw new PluginException("ComponentGroup with name $name not found!");
    }

    /**
     * @param string $name
     * @return array [position => group]
     */
    public function findActiveComponentGroups(string $name): array
    {
        $map = array_filter($this->getActiveComponentGroups(), function ($v) use ($name) {
            /** @var ComponentGroup $v */
            return $v->name === $name;
        });
        if (!empty($map)) return $map;
        else throw new PluginException("Active ComponentGroup with name $name not found!");
    }

    public function getActiveComponentGroups()
    {
        return iterator_to_array($this->activeComponentGroups);
    }

    public function activateComponentGroup(string $name)
    {
        var_dump("Active groups before activateComponentGroup: " . $this->activeComponentGroups->count());
        /** @var ComponentGroup|null $componentgroup */
        $componentgroup = $this->findComponentGroup($name);
        $componentgroup->apply($this->entity);
        $this->activeComponentGroups->push($componentgroup);
        var_dump("Active groups after activateComponentGroup: " . $this->activeComponentGroups->count());
    }

    public function deactivateComponentGroup(string $name)
    {
        var_dump("Active groups before deactivateComponentGroup: " . $this->activeComponentGroups->count());
        /** @var ComponentGroup|null $componentGroup */
        foreach ($this->findActiveComponentGroups($name) as $index => $componentGroup) {
            $componentGroup->remove($this->entity);
            $this->activeComponentGroups->offsetUnset($index);
        }
        var_dump("Active groups after deactivateComponentGroup: " . $this->activeComponentGroups->count());
    }

    //TODO use SplQueue? TODO Move to Loader?
    public function getEvents(): array
    {
        return Loader::$events[$this->getBehaviourName()] ?? [];
    }

    public function getEventData(string $event): array
    {
        $data = $this->getEvents()[$event] ?? [];
        if (empty($data)) Loader::getInstance()->getLogger()->alert("An AddonEvent was called, but no such definition was found: " . $event . " in " . $this->getBehaviourName());
        return $data;
    }
}