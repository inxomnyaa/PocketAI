<?php

namespace xenialdan\PocketAI;

use pocketmine\plugin\PluginException;
use xenialdan\PocketAI\entitytype\AIEntity;

class EntityProperties{
	private $behaviour = "empty";
	/** @var null|AIEntity */
	private $entity;
	private $behaviourFile = [];
	/** @var array */
	public $componentGroups = [];

	/**
	 * EntityProperties constructor.
	 * @param $behaviour
	 * @param AIEntity|null $entity
	 */
	public function __construct($behaviour, AIEntity $entity = null){
		if (!array_key_exists($behaviour, Loader::$behaviour)) throw new \InvalidArgumentException("Entity behaviour/properties file: " . $behaviour . " not found" . (is_null($entity) ? "" : " for entity of type " . $entity->getName()));
		$this->behaviour = $behaviour;
		$this->behaviourFile = Loader::$behaviour[$this->behaviour];
		if (version_compare($this->behaviourFile["minecraft:entity"]["format_version"] ?? "1.2.0", "1.2.0") !== 0){
			throw new \InvalidArgumentException("The Entity behaviour/properties file: " . $behaviour . " has an unsupported format_version and will not be used");
		}
		$this->entity = $entity;
	}

	/**
	 * @return array
	 */
	public function getBehaviours(): array{
		return $this->behaviourFile;
	}

	public function getBehaviourComponentGroups(){
		return $this->behaviourFile["minecraft:entity"]["component_groups"];
	}

	public function getBehaviourComponentGroup(string $component_group_name){
		return $this->getBehaviourComponentGroups()[$component_group_name]??null;
	}

	public function getBehaviourComponents(){
		return $this->behaviourFile["minecraft:entity"]["components"];
	}

	public function getBehaviourEvents(){
		return $this->behaviourFile["minecraft:entity"]["events"];
	}

	public function getActiveComponentGroups(){
		var_dump("============ ACTIVE GROUPS ============");
		var_dump($this->componentGroups);
		return $this->componentGroups;
	}

	public function addActiveComponentGroup($component_group_name){
		var_dump("============ ADD GROUP NAME ============");
		var_dump($component_group_name);
		/*if(!is_null(($component_group = $this->getBehaviourComponentGroup($component_group_name)))){
			$this->componentGroups[] = $component_group_name;
			foreach ($component_group as $group_data){
				//TODO set the groups properties
				var_dump("============ ADDED GROUP DATA ============");
				var_dump($group_data);
			}
		}*/
		var_dump("============ ACTIVE GROUPS ============");
		var_dump($this->getActiveComponentGroups());
	}

	public function removeActiveComponentGroup($componentGroup){
		//TODO set the groups properties
		unset($this->componentGroups[$componentGroup]);
	}

	public function applyEvent($behaviourEvent_data){
		var_dump("============ EVENT DATA ============");
		var_dump($behaviourEvent_data);
		foreach ($behaviourEvent_data as $function => $function_properties){
			var_dump("============ EVENT ============");
			var_dump($function);
			switch ($function){
				case "randomize": {
					$array = [];
					foreach ($function_properties as $index => $property){
						$array[] = $property["weight"] ?? 1;
					}
					//TODO temp fix, remove when fixed
					$subEvents = $function_properties[$this->getRandomWeightedElement($array)];
					var_dump("============ SUBEVENTS ============");
					var_dump($subEvents);
					#$this->applyEvent($subEvents);
					break;
				}
				case "add": {
					var_dump("============ FUNCTION PROPERTIES INSIDE ADD ============");
					var_dump($function_properties);
					foreach ($function_properties as $function_property => $function_property_data){
						var_dump("============ FUNCTION PROPERTY NAME ============");
						var_dump($function_property);
						var_dump("============ FUNCTION DATA ============");
						var_dump($function_property_data);
						switch ($function_property){
							case "component_groups": {
								//TODO apply component group's data
								foreach ($function_property_data as $componentgroup){
									var_dump("============ COMPONENT GROUP NAME ============");
									var_dump($componentgroup);
									//TODO THIS IS JUST A TEST!
									#$this->addActiveComponentGroup($componentgroup);
								}
								break;
							}
							default: {
								$this->entity->getLevel()->getServer()->getLogger()->notice("Function \"" . $function_property . "\" for add component events is not coded into the plugin yet");
							}
						}
					}
					break;
				}
				case "remove": {
					foreach ($function_properties as $function_property => $function_property_data){
						switch ($function_property){
							case "component_group": {
								//TODO remove component group's data
								foreach ($function_property_data as $componentgroup){
									//TODO THIS IS JUST A TEST!
									$this->removeActiveComponentGroup($componentgroup);
								}
								break;
							}
						}
					}
					break;
				}
				case "weight": {
					//just a property, ignore it
					break;
				}
				default: {
					$this->entity->getLevel()->getServer()->getLogger()->notice("Function \"" . $function . "\" for behaviour events is not coded into the plugin yet");
				}
			}
		}
	}

	/**
	 * https://stackoverflow.com/a/11872928/4532380
	 * getRandomWeightedElement()
	 * Utility function for getting random values with weighting.
	 * Pass in an associative array, such as array('A'=>5, 'B'=>45, 'C'=>50)
	 * An array like this means that "A" has a 5% chance of being selected, "B" 45%, and "C" 50%.
	 * The return value is the array key, A, B, or C in this case.  Note that the values assigned
	 * do not have to be percentages.  The values are simply relative to each other.  If one value
	 * weight was 2, and the other weight of 1, the value with the weight of 2 has about a 66%
	 * chance of being selected.  Also note that weights should be integers.
	 *
	 * @param int[] $weightedValues
	 * @return mixed $key
	 */
	public static function getRandomWeightedElement(array $weightedValues){
		if (empty($weightedValues)){
			throw new PluginException("Config error! No sets exist in the config - don't you want to give the players anything?");
		}
		$rand = mt_rand(1, (int)array_sum($weightedValues));

		foreach ($weightedValues as $key => $value){
			$rand -= $value;
			if ($rand <= 0){
				return $key;
			}
		}
		return -1;
	}
}