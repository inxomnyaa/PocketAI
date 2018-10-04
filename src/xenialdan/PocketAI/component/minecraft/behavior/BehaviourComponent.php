<?php


namespace xenialdan\PocketAI\component\minecraft\behavior;


use xenialdan\PocketAI\component\BaseComponent;

abstract class BehaviourComponent extends BaseComponent
{
    public $priority = PHP_INT_MAX;

    /**
     * BehaviourComponent constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->priority = $values['priority'] ?? $this->priority;
    }

    public abstract function tick(int $tickDiff);
}