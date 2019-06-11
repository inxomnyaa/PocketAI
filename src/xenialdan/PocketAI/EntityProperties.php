<?php

namespace xenialdan\PocketAI;

use pocketmine\entity\DataPropertyManager;
use pocketmine\inventory\InventoryHolder;
use pocketmine\plugin\PluginException;
use xenialdan\PocketAI\component\BaseComponent;
use xenialdan\PocketAI\component\ComponentGroup;
use xenialdan\PocketAI\component\ComponentGroups;
use xenialdan\PocketAI\component\Components;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class EntityProperties extends DataPropertyManager
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
     * @return Components
     */
    public function getComponents(): Components
    {
        return $this->components;
    }

    /**
     * @return array[\SplQueue]
     */
    public function getComponentsArray(): array
    {
        return iterator_to_array($this->components);
    }

    public function findComponents(string $name): Components//TODO optimize
    {
        if (class_exists($name) && is_subclass_of($name, BaseComponent::class)) $name = (new $name)->getName();
        $c = new Components();
        if (!$this->hasComponent($name)) return $c;
        $map = array_filter($this->getComponentsArray(), function ($v) use ($name) {
            /** @var BaseComponent $v */
            return $v->getName() === $name;
        });
        foreach ($this->getActiveComponentGroups() as $componentGroup) {
            /** @var ComponentGroup $componentGroup */
            $map = array_merge(array_filter($componentGroup->getComponentsArray(), function ($v) use ($name) {//TODO check if array_merge removes components
                /** @var BaseComponent $v */
                return $v->getName() === $name;
            }), $map);
        }
        foreach ($map as $value) {
            $c->push($value);
        }
        //if ($c->count() === 0) Loader::getInstance()->getLogger()->debug("No Component with name $name found");
        return $c;
    }

    public function hasComponent(string $name): bool
    {
        if (class_exists($name) && is_subclass_of($name, BaseComponent::class)) $name = (new $name)->getName();
        foreach ($this->getComponentsArray() as $v) {
            /** @var BaseComponent $v */
            if ($v->getName() === $name) return true;
        };
        foreach ($this->getActiveComponentGroups() as $componentGroup) {
            /** @var ComponentGroup $componentGroup */
            foreach ($componentGroup->getComponentsArray() as $v) {
                /** @var BaseComponent $v */
                if ($v->getName() === $name) return true;
            };
        }
        return false;
    }

    /**
     * @return array[ComponentGroup]
     */
    public function getComponentGroupsArray(): array
    {
        return iterator_to_array($this->componentGroups);
    }

    /**
     * @return ComponentGroups
     */
    public function getComponentGroups(): ComponentGroups
    {
        return $this->componentGroups;
    }

    /**
     * This might return multiple components with the same name due to multi-support for minecraft:interact, environment_sensor and damage_sensor!
     * @param string $name
     * @return ComponentGroups
     */
    public function findComponentGroups(string $name): ComponentGroups
    {
        $map = array_filter($this->getComponentGroupsArray(), function ($v) use ($name) {
            /** @var ComponentGroup $v */
            return $v->name === $name;
        });
        $cg = new ComponentGroups();
        if (empty($map)) Loader::getInstance()->getLogger()->debug("No ComponentGroup with name $name found");
        else {
            foreach ($map as $value) {
                $cg->push($value);
            }
        }
        return $cg;
    }

    /**
     * @param string $name
     * @return array [position => group] this might return multiple groups!
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

    /**
     * @return array
     */
    public function getActiveComponentGroups()
    {
        return iterator_to_array($this->activeComponentGroups);
    }

    public function activateComponentGroup(string $name)
    {
        var_dump("Active groups before activateComponentGroup: " . $this->activeComponentGroups->count());
        /** @var ComponentGroups $componentgroup */
        foreach ($this->findComponentGroups($name) as $componentGroup) {
            $componentGroup->apply($this->entity);
            $this->activeComponentGroups->push($componentGroup);
        }
        var_dump("Active groups after activateComponentGroup: " . $this->activeComponentGroups->count());
    }

    public function deactivateComponentGroup(string $name)
    {
        var_dump("Active groups before deactivateComponentGroup: " . $this->activeComponentGroups->count());
        /** @var array[ComponentGroup] $componentGroup */
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