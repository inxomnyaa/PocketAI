<?php


namespace xenialdan\PocketAI\component;


use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\entitytype\AIProjectile;

class ComponentGroup
{

    /** @var Components */
    private $components;

    public $name = "Unknown";

    /**
     * BaseComponent constructor.
     * @param string $name
     * @param BaseComponent[] $components
     */
    public function __construct(string $name, array $components = [])
    {
        $this->name = $name;
        foreach ($components as $component)
            $this->addComponent($component);
    }

    /**
     * @param BaseComponent $component
     */
    public function addComponent(BaseComponent $component)
    {
        $this->components->push($component);
    }

    /**
     * @param int $index
     */
    public function removeComponent(int $index)
    {
        if ($this->components->offsetExists($index))
            $this->components->offsetUnset($index);
    }

    /**
     * Applies the changes to the mob
     * @param AIEntity|AIProjectile $entity
     */
    public function apply($entity): void
    {
        $this->components->rewind();
        /** @var BaseComponent $current */
        while (($current = $this->components->current())) {
            $current->apply($entity);
            $this->components->next();
        }
    }

    /**
     * Removes the changes from the mob
     * @param AIEntity|AIProjectile $entity
     */
    public function remove($entity): void
    {
        $this->components->rewind();
        while ($this->components->valid()) {
            /** @var BaseComponent $current */
            $current = $this->components->pop();
            $current->remove($entity);
        }
    }
}