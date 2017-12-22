<?php

namespace xenialdan\PocketAI;

use pocketmine\plugin\PluginException;
use xenialdan\PocketAI\entitytype\AIEntity;

class AI{
	/** @var null|AIEntity */
	private $entity;
	private $active = [];

	/**
	 * EntityProperties constructor.
	 * @param AIEntity|null $entity
	 */
	public function __construct(AIEntity $entity = null){
		$this->entity = $entity;
	}

	/**
	 * @return array
	 */
	public function getActive(): array{
		return $this->active;
	}

	/**
	 * @param array $active
	 */
	public function setActive(array $active){
		$this->active = $active;
	}
}