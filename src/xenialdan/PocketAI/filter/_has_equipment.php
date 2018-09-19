<?php

namespace xenialdan\PocketAI\filter;

use pocketmine\entity\Entity;
use pocketmine\entity\Human;
use pocketmine\entity\Living;
use pocketmine\inventory\InventoryHolder;
use pocketmine\item\Item;
use xenialdan\PocketAI\entitytype\AIEntity;

class _has_equipment extends BaseFilter
{
    protected $name = "has_equipment";
    /** @var string $domain (Optional) The equipment location to test */
    public $domain = "any";
    /** @var string $operator (Optional) The comparison to apply with 'value'. */
    public $operator = "equals";
    /** @var string $subject (Optional) The subject of this filter test. */
    public $subject = "self";
    /** @var string $value (Required) The item name to look for */
    public $value;

    /**
     * Tests for the presence of a named item in the designated slot of the subject entity.
     * _has_equipment constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->domain = $values['domain'] ?? $this->domain;
        $this->operator = $values['operator'] ?? $this->operator;
        $this->subject = $values['subject'] ?? $this->subject;
        $this->value = $values['value'] ?? $this->value;

    }

    public function test(AIEntity $caller, Entity $other): bool
    {
        $return = parent::test($caller, $other);
        if (!$return) return $return;
        if (!$this->subjectToTest instanceof InventoryHolder) return false;
        $item = Item::fromString($this->value);
        if ($item->isNull()) return false;
        switch ($this->domain) {
            case "any":
                {
                    return $this->subjectToTest->getInventory()->contains($item);
                    break;
                }
            case "armor":
                {
                    if (!$this->subjectToTest instanceof Living) return false;
                    return $this->subjectToTest->getArmorInventory()->contains($item);
                    break;
                }
            case "feet":
                {
                    if (!$this->subjectToTest instanceof Living) return false;
                    return $this->subjectToTest->getArmorInventory()->getBoots()->equals($item, true);
                    break;
                }
            case "hand":
                {
                    if (!$this->subjectToTest instanceof Human) return false;
                    return $this->subjectToTest->getInventory()->getItemInHand()->equals($item, true);
                    break;
                }
            case "head":
                {
                    if (!$this->subjectToTest instanceof Living) return false;
                    return $this->subjectToTest->getArmorInventory()->getHelmet()->equals($item, true);
                    break;
                }
            case "leg":
                {
                    if (!$this->subjectToTest instanceof Living) return false;
                    return $this->subjectToTest->getArmorInventory()->getLeggings()->equals($item, true);
                    break;
                }
            case "torso":
                {
                    if (!$this->subjectToTest instanceof Living) return false;
                    return $this->subjectToTest->getArmorInventory()->getChestplate()->equals($item, true);
                    break;
                }
        }
        return false;
    }
}