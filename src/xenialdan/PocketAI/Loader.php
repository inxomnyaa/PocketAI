<?php

namespace xenialdan\PocketAI;

use pocketmine\entity\Attribute;
use pocketmine\entity\Entity;
use pocketmine\item\ItemFactory;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\SetEntityLinkPacket;
use pocketmine\network\mcpe\protocol\types\EntityLink;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\resourcepacks\ZippedResourcePack;
use pocketmine\Server;
use xenialdan\PocketAI\command\KillentityCommand;
use xenialdan\PocketAI\command\SummonCommand;
use xenialdan\PocketAI\component\ComponentGroup;
use xenialdan\PocketAI\component\ComponentGroups;
use xenialdan\PocketAI\component\Components;
use xenialdan\PocketAI\entity\Cow;
use xenialdan\PocketAI\entity\FishingHook;
use xenialdan\PocketAI\entity\LeashKnot;
use xenialdan\PocketAI\entitytype\AIEntity;
use xenialdan\PocketAI\item\FishingRod;
use xenialdan\PocketAI\item\Lead;
use xenialdan\PocketAI\listener\AddonEventListener;
use xenialdan\PocketAI\listener\EventListener;
use xenialdan\PocketAI\listener\InventoryEventListener;
use xenialdan\PocketAI\listener\RidableEventListener;

class Loader extends PluginBase
{
    const HORSE_JUMP_POWER = 11;
    /** @var Loader */
    private static $instance = null;

    public static $behaviourJson = [];
    /** @var array[Components] */
    public static $components;
    /** @var array[ComponentGroups] */
    public static $component_groups;
    /** @var array[] */
    public static $events;
    public static $loottables = [];

    public static $links = [];
    public static $hooks = [];

    /**
     * Returns an instance of the plugin
     * @return Loader
     */
    public static function getInstance()
    {
        return self::$instance;
    }

    public function onLoad()
    {
        self::$instance = $this;
    }

    public function onEnable()
    {
        $this->getServer()->getCommandMap()->register("pocketmine", new SummonCommand("summon"));
        $this->getServer()->getCommandMap()->register("pocketmine", new KillentityCommand("killentity"));
        #Attribute::addAttribute(Loader::HORSE_JUMP_POWER, "minecraft:horse_jump_power", 0.00, 4.00, 1.00);
        Attribute::addAttribute(Loader::HORSE_JUMP_POWER, "minecraft:horse.jump_strength", 0.00, 4.00, 1.00);

        foreach ($this->getServer()->getResourcePackManager()->getResourceStack() as $resourcePack) {//TODO check if the priority is ordered in that way, that the top pack overwrites the lower packs
            if ($resourcePack instanceof ZippedResourcePack) {
                $za = new \ZipArchive();

                $za->open($resourcePack->getPath());

                for ($i = 0; $i < $za->numFiles; $i++) {
                    $stat = $za->statIndex($i);
                    if (explode(DIRECTORY_SEPARATOR, $stat['name'])[0] === "entities") {
                        self::$behaviourJson[str_replace(DIRECTORY_SEPARATOR, "/", str_replace(".json", "", $stat['name']))] = json_decode($za->getFromIndex($i), true);
                    } elseif (explode(DIRECTORY_SEPARATOR, $stat['name'])[0] === "loot_tables") {
                        self::$loottables[str_replace(DIRECTORY_SEPARATOR, "/", str_replace(".json", "", $stat['name']))] = json_decode($za->getFromIndex($i), true);
                    } else {
                        $this->getLogger()->warning("Did not load file: " . explode(DIRECTORY_SEPARATOR, $stat['name'])[0] . " -=+=- " . $stat['name']);
                    }
                }

                $za->close();
            }
        }

        $this->preloadJson(self::$behaviourJson);
        $this->registerEntities();
        $this->registerItems();
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new InventoryEventListener($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new RidableEventListener($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new AddonEventListener($this), $this);

        $this->debug();
    }

    private function debug()
    {
        try {
            $e = new Cow($this->getServer()->getDefaultLevel(), Cow::createBaseNBT($this->getServer()->getDefaultLevel()->getSpawnLocation()->asVector3()));
            $entityProperties = $e->getEntityProperties();
            if (is_null($entityProperties)) return;
            $this->getLogger()->debug(">==========< getBehaviourName >==========<");
            $this->getLogger()->debug(print_r($entityProperties->getBehaviourName(), true));
            $this->getLogger()->debug(">==========< getEvents >==========<");
            $this->getLogger()->debug(print_r($entityProperties->getEvents(), true));
            $this->getLogger()->debug(">==========< getComponents >==========<");
            $this->getLogger()->debug(print_r($entityProperties->getComponents(), true));
            $this->getLogger()->debug(">==========< getComponentGroups >==========<");
            $this->getLogger()->debug(print_r($entityProperties->getComponentGroups(), true));
            $this->getLogger()->debug(">==========< findComponents >==========<");
            $this->getLogger()->debug(print_r($entityProperties->findComponents("minecraft:identifier"), true));
            $this->getLogger()->debug(">==========< findComponents more than 1 entry >==========<");
            $this->getLogger()->debug(print_r($entityProperties->findComponents("minecraft:behavior.follow_parent"), true));
            $this->getLogger()->debug(">==========< findComponentGroups >==========<");
            $this->getLogger()->debug(print_r($entityProperties->findComponentGroups("minecraft:cow_adult"), true));
            $this->getLogger()->debug(">==========< getActiveComponentGroups >==========<");
            $this->getLogger()->debug(print_r($entityProperties->getActiveComponentGroups(), true));
            $this->getLogger()->debug(">==========< Cow! >==========<");
            $this->getLogger()->debug(print_r($e, true));
            $e->kill();
        } catch (\Exception $exception) {
            print_r($exception);
        }
    }

    private function preloadJson(array $behaviourJsonFiles)
    {
        try {
            foreach ($behaviourJsonFiles as $filename => $behaviour) {
                $currentFilename = $filename;
                if (version_compare($behaviour["minecraft:entity"]["format_version"] ?? "1.2.0", "1.2.0") !== 0) {
                    $this->getLogger()->notice("The Entity behaviour/properties file: " . $filename . " has an unsupported format_version and will not be used");
                    continue;
                }

                //Components
                self::$components[$filename] = new Components();
                foreach ($behaviour["minecraft:entity"]["components"] ?? [] as $component_name => $component_data) {
                    $c = "xenialdan\\PocketAI\\component\\" . preg_replace('/(\\\\(?!.*\\\\.*))/', '\\_', str_replace(":", "\\", join("\\", explode(".", $component_name))));
                    if (class_exists($c)) {
                        self::$components[$filename]->push(new $c(is_array($component_data) ? $component_data : [$component_data]));
                    }
                }
                //Component groups
                self::$component_groups[$filename] = new ComponentGroups();
                foreach ($behaviour["minecraft:entity"]["component_groups"] ?? [] as $component_group_name => $component_group_data) {
                    $groups = [];
                    /**
                     * @var string $component_name
                     * @var array $component_data
                     */
                    foreach ($component_group_data ?? [] as $component_name => $component_data) {
                        $c = "xenialdan\\PocketAI\\component\\" . preg_replace('/(\\\\(?!.*\\\\.*))/', '\\_', str_replace(":", "\\", join("\\", explode(".", $component_name))));
                        if (class_exists($c)) {

                            //Multi-definition for component, i.e. in minecraft:interact - so, add the component several times
                            if (count($component_data) > 0 && $component_data ===
                                array_filter($component_data,
                                    function ($key) {
                                        return is_int($key);
                                    },
                                    ARRAY_FILTER_USE_KEY
                                )
                            ) {
                                $this->getLogger()->notice("MULTIPLE!");
                                foreach ($component_data as $component_datum) {
                                    print_r($component_datum);
                                    if ($component_name == "minecraft:environment_sensor")//This is due to a probable Mojang-Json-Coding issue in dolphin.json. Investigating.
                                        $groups[] = new $c(["on_environment" => $component_datum]);
                                    else
                                        $groups[] = new $c($component_datum);
                                    print_r($groups[count($groups) - 1]);
                                }
                            } else {
                                $this->getLogger()->notice("SINGLE!");
                                $groups[] = new $c($component_data);
                                print_r($groups[count($groups) - 1]);
                            }
                        }
                    }
                    self::$component_groups[$filename]->push(new ComponentGroup($component_group_name, $groups));
                }
                //Events
                self::$events[$filename] = $behaviour["minecraft:entity"]["events"] ?? [];
            }
        } catch (\Exception $e) {
            $this->getLogger()->alert("An exception has occurred whilest preloading the behaviours (File: " . $currentFilename . "): " . $e);
        } finally {
            $this->getLogger()->notice("Behaviours successfully pre-loaded and cached! Sizes (should match!): Components: " . sizeof(self::$components) . " Component groups: " . sizeof(self::$component_groups) . " Events: " . sizeof(self::$events));
        }
    }

    public function registerEntities()
    {
        Entity::registerEntity(Cow::class, true, ["pocketai:cow", "minecraft:cow"]);//TODO use _identifier
        $this->getLogger()->notice("Registered AI for: Cow");
        Entity::registerEntity(LeashKnot::class, true, ["pocketai:leash_knot", "minecraft:leash_knot"]);
        $this->getLogger()->notice("Registered Entity: LeashKnot");
    }

    public function registerItems()
    {
        ItemFactory::registerItem($item = new FishingRod(), true);
        $this->getLogger()->notice("Registered Item: " . $item->getName());
        ItemFactory::registerItem($item = new Lead(), true);
        $this->getLogger()->notice("Registered Item: " . $item->getName());
    }

    public static function isRiding(Entity $entity)
    {
        return ($entity->getDataFlag(Entity::DATA_FLAGS, Entity::DATA_FLAG_RIDING) && !is_null(Loader::getLink($entity)));
    }

    /**
     * @param Entity $main
     * @param Entity $passenger
     * @param int $type
     */
    public static function setEntityLink(Entity $main, Entity $passenger, int $type = 1)
    {
        if ($main->isAlive() and $passenger->isAlive() and $main->getLevel() === $passenger->getLevel()) {
            if (self::isRiding($passenger) && $type !== 0) self::setEntityLink($main, $passenger, 0);
            #$main->setDataProperty(Entity::DATA_OWNER_EID, Entity::DATA_TYPE_LONG, $passenger->getId());
            #$passenger->setDataFlag(Entity::DATA_FLAGS, Entity::DATA_FLAG_RIDING, $type !== 0);
            $passenger->setDataFlag(Entity::DATA_FLAGS, Entity::DATA_FLAG_RIDING, $type === 0);
            #if($passenger instanceof Player) $passenger->setAllowFlight(false); //TODO this insta-kicks
            switch ($type) {
                case 0:
                    {//unlink
                        $pk = new SetEntityLinkPacket();
                        $pk->link = Loader::getLink($passenger);
                        $pk->link->type = $type;
                        $main->getLevel()->getServer()->broadcastPacket($main->getLevel()->getPlayers(), $pk);

                        Loader::removeLink($pk->link);
                        break;
                    }
                case 1:
                    {//rider?
                        $pk = new SetEntityLinkPacket();
                        $pk->link = new EntityLink();
                        $pk->link->fromEntityUniqueId = $main->getId();
                        $pk->link->toEntityUniqueId = $passenger->getId();
                        $pk->link->type = $type;
                        $main->getLevel()->getServer()->broadcastPacket($main->getLevel()->getPlayers(), $pk);

                        Loader::setLink($pk->link);
                        if ($passenger instanceof Player) $passenger->setAllowFlight(true); //TODO stupid dan, this allows you to fly in GMS/GMA. Create a proper workaround.

                        #$pk = new SetEntityLinkPacket();
                        #$link = new EntityLink();
                        #$link->fromEntityUniqueId = $main->getId();
                        #$link->type = $type;
                        #$link->toEntityUniqueId = 0;
                        #$link->bool1 = true;
                        #$main->getLevel()->getServer()->broadcastPacket($main->getLevel()->getPlayers(), $pk);

                        #$passenger->setDataFlag(Entity::DATA_FLAGS, Entity::DATA_FLAG_RIDING, true);
                        $main->setDataFlag(Entity::DATA_FLAGS, Entity::DATA_FLAG_SADDLED, true);
                        $passenger->setDataFlag(Entity::DATA_FLAGS, Entity::DATA_FLAG_CAN_POWER_JUMP, true);
                        if ($main instanceof AIEntity) {
                            $position = $main->getSeats()[0]["position"] ?? [0, 0, 0];
                            $passenger->getDataPropertyManager()->setVector3(Entity::DATA_RIDER_SEAT_POSITION, new Vector3($position[0], $position[1] * 2, $position[2]));//TODO correct seat number
                        }
                        break;
                    }
                /*case 2: {//companion? //TODO multi-links
                    $pk = new SetEntityLinkPacket();
                    $pk->link = new EntityLink();
                    $pk->link->fromEntityUniqueId = $main->getId();
                    $pk->link->toEntityUniqueId = $passenger->getId();
                    $pk->link->type = $type;
                    $pk->link->bool1 = true;
                    $main->getLevel()->getServer()->broadcastPacket($main->getLevel()->getPlayers(), $pk);

                    Loader::setLink($pk->link);
                    $passenger->getDataPropertyManager()->setVector3(Entity::DATA_RIDER_SEAT_POSITION, Vector3(0, $main->getEyeHeight() + ($passenger->getEyeHeight() / 2), 0));//TODO
                    break;
                }*/
            }
        }
    }

    /**
     * @param Entity $entity
     * @return null|EntityLink
     */
    public static function getLink(Entity $entity): ?EntityLink
    {
        return Loader::$links[$entity->getId()] ?? null; //TODO multi-links
    }

    /**
     * @param EntityLink $link
     */
    public static function setLink(EntityLink $link)
    {
        Loader::$links[$link->toEntityUniqueId] = $link;
    }

    /**
     * @param EntityLink $link
     */
    public static function removeLink(EntityLink $link)
    {
        unset(Loader::$links[$link->toEntityUniqueId]);
    }

    /**
     * @param EntityLink $link
     * @return null|Entity
     */
    public static function getEntityLinkMainEntity(EntityLink $link): ?Entity
    {
        return Server::getInstance()->findEntity($link->fromEntityUniqueId);
    }

    public static function getHook(Player $player): ?FishingHook
    {
        $id = self::$hooks[$player->getId()] ?? -1;
        if ($id === -1) return null;
        $entity = $player->getServer()->findEntity($id);
        if ($entity instanceof FishingHook) return $entity;
        return null;
    }

    public static function setHook(Player $player, ?FishingHook $hook)
    {
        if ($hook instanceof FishingHook) {
            self::$hooks[$hook->getOwningEntityId()] = $hook->getId();
        } else {
            unset(self::$hooks[$player->getId()]);
        }
    }
}