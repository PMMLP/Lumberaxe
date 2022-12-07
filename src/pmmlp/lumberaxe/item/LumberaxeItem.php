<?php

declare(strict_types=1);

namespace pmmlp\lumberaxe\item;

use customiesdevs\customies\item\component\DiggerComponent;
use customiesdevs\customies\item\component\DurabilityComponent;
use customiesdevs\customies\item\component\HandEquippedComponent;
use customiesdevs\customies\item\CreativeInventoryInfo;
use customiesdevs\customies\item\ItemComponents;
use customiesdevs\customies\item\ItemComponentsTrait;
use pmmlp\lumberaxe\util\LumberaxeConfig;
use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\block\Log;
use pocketmine\block\VanillaBlocks;
use pocketmine\item\Axe;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ToolTier;
use pocketmine\world\particle\BlockBreakParticle;
use pocketmine\world\World;

class LumberaxeItem extends Axe implements ItemComponents {
    use ItemComponentsTrait;

    public function __construct(ItemIdentifier $identifier, string $name){
        parent::__construct($identifier, $name, ToolTier::DIAMOND());
        $this->initComponent("lumberaxe", new CreativeInventoryInfo(CreativeInventoryInfo::CATEGORY_EQUIPMENT, CreativeInventoryInfo::GROUP_AXE));
        $this->addComponent(new DurabilityComponent($this->tier->getMaxDurability()));
        $blocks = array_filter(BlockFactory::getInstance()->getAllKnownStates(), function(Block $block): bool {
            return $block instanceof Log;
        });
        $this->addComponent((new DiggerComponent())->withBlocks(5, ...$blocks));
        $this->addComponent(new HandEquippedComponent());
    }

    public function onDestroyBlock(Block $block): bool{
        if($block instanceof Log) {
            $position = $block->getPosition();

            $alreadyChecked = [World::chunkBlockHash($position->getFloorX(), $position->getFloorY(), $position->getFloorZ())];
            $destroyed = 0;
            $this->destroyBlocks($block, $alreadyChecked, $destroyed);
        }
        if(!$block->getBreakInfo()->breaksInstantly()){
            return $this->applyDamage(1);
        }
        return false;
    }

    public function destroyBlocks(Block $block, array &$alreadyChecked, int &$destroyed): void {
        $world = $block->getPosition()->getWorld();
        $air = VanillaBlocks::AIR();
        foreach($block->getAllSides() as $side) {
            $sidePosition = $side->getPosition();
            $hash = World::chunkBlockHash($sidePosition->getFloorX(), $sidePosition->getFloorY(), $sidePosition->getFloorZ());
            if(in_array($hash, $alreadyChecked, false)) {
                continue;
            }
            $alreadyChecked[] = $hash;
            if($block->isSameType($side)) {
                if(++$destroyed >= LumberaxeConfig::$maxBlocksToBreak) {
                    return;
                }
                $this->destroyBlocks($side, $alreadyChecked, $destroyed);

                $world->addParticle($sidePosition, new BlockBreakParticle($side));
                $world->setBlock($sidePosition, $air);
                foreach($side->getDrops($this) as $item) {
                    $world->dropItem($block->getPosition(), $item);
                }

                if(LumberaxeConfig::$damageAxeForEachBlock && !$this->applyDamage(1)){
                    return;
                }
            }
        }
    }
}