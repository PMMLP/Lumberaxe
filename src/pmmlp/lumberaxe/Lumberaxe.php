<?php

declare(strict_types=1);

namespace pmmlp\lumberaxe;

use customiesdevs\customies\item\CustomiesItemFactory;
use pmmlp\crafting\CraftingRecipeRegistry;
use pmmlp\lumberaxe\block\LeavesBlock;
use pmmlp\lumberaxe\item\LumberaxeItem;
use pmmlp\lumberaxe\util\LumberaxeConfig;
use pmmlp\util\resourcepack\ResourcePackLoader;
use pocketmine\block\BlockBreakInfo;
use pocketmine\block\BlockFactory;
use pocketmine\block\BlockIdentifier;
use pocketmine\block\BlockLegacyIds;
use pocketmine\block\BlockToolType;
use pocketmine\block\utils\TreeType;
use pocketmine\plugin\PluginBase;

class Lumberaxe extends PluginBase {
    protected function onEnable(): void{
        new LumberaxeConfig($this);
        new ResourcePackLoader($this, $this->getFile());

        CustomiesItemFactory::getInstance()->registerItem(LumberaxeItem::class, "pmmlp:lumberaxe", "Lumberaxe");

        if(LumberaxeConfig::$fastLeavesDecay) {
            $leavesBreakInfo = new BlockBreakInfo(0.2, BlockToolType::SHEARS);
            foreach(TreeType::getAll() as $treeType) {
                $magicNumber = $treeType->getMagicNumber();
                $name = $treeType->getDisplayName();
                BlockFactory::getInstance()->register(new LeavesBlock(new BlockIdentifier($magicNumber >= 4 ? BlockLegacyIds::LEAVES2 : BlockLegacyIds::LEAVES, $magicNumber & 0x03), $name . " Leaves", $leavesBreakInfo, $treeType), true);
            }
        }

        if(LumberaxeConfig::$registerRecipe) {
            CraftingRecipeRegistry::registerRecipe(LumberaxeConfig::recipe());
        }
    }
}