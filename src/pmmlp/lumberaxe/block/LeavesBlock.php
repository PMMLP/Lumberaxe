<?php

declare(strict_types=1);

namespace pmmlp\lumberaxe\block;

use pmmlp\lumberaxe\util\LumberaxeConfig;
use pocketmine\block\Leaves;
use pocketmine\event\block\LeavesDecayEvent;

class LeavesBlock extends Leaves {
    public function onNearbyBlockChange() : void{
        if(!$this->noDecay && !$this->checkDecay){
            $this->checkDecay = true;
            $this->position->getWorld()->setBlock($this->position, $this, false);
            $this->position->getWorld()->scheduleDelayedBlockUpdate($this->position->asVector3(), random_int(1, LumberaxeConfig::$maxLeavesDecayTicks));
        }
    }

    public function onScheduledUpdate(): void{
        $this->checkDecay();
    }

    public function onRandomTick() : void{
        $this->checkDecay();
    }

    protected function checkDecay(): void {
        if(!$this->noDecay && $this->checkDecay){
            $ev = new LeavesDecayEvent($this);
            $ev->call();
            if($ev->isCancelled() or $this->findLog($this->position)){
                $this->checkDecay = false;
                $this->position->getWorld()->setBlock($this->position, $this, false);
            }else{
                $this->position->getWorld()->useBreakOn($this->position);
            }
        }
    }
}