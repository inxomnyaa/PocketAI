<?php

namespace xenialdan\PocketAI;


use xenialdan\PocketAI\entitytype\AIEntity;

class SkillTree{
	// TODO translation keys -> translation
	//TODO add more constants
	const ACTION_HOVER = "action.hover";
	const ACTION_RIGHT_CLICK = "action.right_click";
	const ACTION_RIGHT_CLICK_SNEAK = "action.right_click_sneak";
	const ACTION_LEFT_CLICK = "action.left_click";
	const ACTION_LEFT_CLICK_SNEAK = "action.left_click_sneak";
	const ACTION_INVENTORY_OPEN = "action.inventory_open";
	const ACTION_FEED = "action.feed";
	const ACTION_TAME = "action.tame";
	const ACTION_SIT = "action.sit";

	const SKILL_JUMP = "skill.jump";
	const SKILL_SIT = "skill.sit";
	const SKILL_SWIM = "skill.swim";
	const SKILL_WALK = "skill.walk";
	const SKILL_FOLLOW_ENTITY = "skill.follow_entity";
	const SKILL_LOOK_AT = "skill.look_at";
	const SKILL_BURN_IN_SUNLIGHT = "skill.burn_in_sunlight";
	const SKILL_ATTACK = "skill.attack";
	const SKILL_CLIMB_WALL = "skill.climb_wall";

	public $entity = null;
	public $skills = [];

	/**
	 * SkillTree constructor.
	 * @param AIEntity $entity
	 * @param string[] ...$skills
	 */
	public function __construct(AIEntity $entity, string ...$skills){
		$this->setEntity($entity);
		$this->setSkills($skills);
	}

	/**
	 * @return null|AIEntity
	 */
	public function getEntity(): ?AIEntity{
		return $this->entity;
	}

	/**
	 * @param null|AIEntity $entity
	 */
	public function setEntity($entity): void{
		$this->entity = $entity;
	}

	/**
	 * @return string[]
	 */
	public function getSkills(): array{
		return $this->skills;
	}

	/**
	 * @param string[] $skills
	 */
	public function setSkills(array $skills): void{
		$this->skills = $skills;
	}

	/**
	 * @param string[] $skills
	 */
	public function addSkills(string ...$skills): void{
		$this->skills = array_merge($this->getSkills(), $skills);
	}

	/**
	 * @param string[] ...$skills
	 */
	public function removeSkills(string ...$skills): void{
		foreach ($skills as $skill){
			if ($this->hasSkill($skill)) unset($this->skills[$skill]);
		}
	}

	/**
	 * @param string $skill
	 * @return bool
	 */
	public function hasSkill(string $skill): bool{
		return in_array($skill, $this->getSkills());
	}
}