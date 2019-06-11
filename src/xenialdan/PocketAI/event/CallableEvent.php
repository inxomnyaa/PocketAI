<?php

namespace xenialdan\PocketAI\event;

use pocketmine\entity\Entity;
use xenialdan\PocketAI\API;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\filter\Filters;
use xenialdan\PocketAI\Loader;

class CallableEvent
{
    /** @var string The event that is to be called */
    private $event;
    /** @var string The target to run this on */
    private $target;
    /** @var Filters Filters */
    private $filters;

    /**
     * CallableEvent constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        if (isset($values['event']))
            $this->event = $values['event'];
        else throw new \InvalidArgumentCountException("Missing event value");
        if (isset($values['target']))
            $this->target = $values['target'];
        else throw new \InvalidArgumentCountException("Missing target value");
        $this->filters = new Filters($values['filters'] ?? []);
    }

    /**
     * @return string
     */
    public function getEvent(): string
    {
        return $this->event;
    }

    /**
     * @param string $event
     */
    public function setEvent(string $event): void
    {
        $this->event = $event;
    }

    /**
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * @param string $target
     */
    public function setTarget(string $target): void
    {
        $this->target = $target;
    }

    /**
     * @param AIEntity $caller
     * @param Entity $other
     * @throws \ReflectionException
     */
    public function execute(AIEntity $caller, Entity $other)
    {
        if (!$this->filters->test($caller, $other)) return;
        $ev = new AddonEvent(Loader::getInstance(), API::targetToTest($caller, $other, $this->target));
        $ev->call();
    }

}