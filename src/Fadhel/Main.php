<?php

namespace Fadhel;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener{

    public function onEnable() : void{
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info(TextFormat::GREEN . "Enabled!");
    }

    public function onDisable() : void{
        $this->getLogger()->info(TextFormat::RED . "Disabled!");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
        switch($command->getName()){
            case "transfer":
                if($sender instanceof Player){
                    $this->openMyForm($sender);
                    $sender->sendMesseage(TextFormat::GREEN . "Select a server!");
                }else{
                    $sender->sendMesseage(TextFormat::RED . "Please run this command in-game");
                }
                break;
        }
        return true;
    }

    public function openMyForm(Player $player) : void{
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function(Player $player, int $data = null){
            $result = $data;
            if($result === null){
                return;
            }
            if($result === 0){
                $player->transfer("play.hyperlandsmc.net");
            }
        });
        $form->setTitle("§lTransferUI");
        $form->setContent("Select server to transfer!");
        $form->addButton("HyperLands");
        $form->sendToPlayer($player);
    }
}
