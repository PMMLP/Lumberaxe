<?php

declare(strict_types=1);

namespace pmmlp\lumberaxe\util;

use pmmlp\config\Config;
use pmmlp\config\ConfigParser;
use pocketmine\crafting\CraftingRecipe;

class LumberaxeConfig extends Config {
    public static int $maxBlocksToBreak = 24;
    public static bool $fastLeavesDecay = true;
    public static int $maxLeavesDecayTicks = 60;
    public static bool $damageAxeForEachBlock = true;
    public static bool $registerRecipe = true;
    public static array $recipe = [
        "items" => [
            "A" => "280::0",
            "B" => "264::0",
            "C" => "388::0"
        ],
        "shaped" => true,
        "shape" => [
            "BCB",
            "BA ",
            " A "
        ],
        "result" => "pmmlp:lumberaxe"
    ];


    private static CraftingRecipe $recipeObject;

    public static function recipe(): CraftingRecipe {
        return self::$recipeObject ??= ConfigParser::getCraftingRecipe(self::$recipe);
    }
}