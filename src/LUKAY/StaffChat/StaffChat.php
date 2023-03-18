<?php

namespace LUKAY\StaffChat;

use LUKAY\StaffChat\commands\StaffChatCommand;
use LUKAY\StaffChat\listener\PlayerJoinListener;
use LUKAY\StaffChat\listener\PlayerQuitListener;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;

class StaffChat extends PluginBase {
    use SingletonTrait;

    private array $onlineStaffMembers = [];

    protected function onLoad(): void {
        $this->saveResource("config.yml");
        self::setInstance($this);
    }

    protected function onEnable(): void {
        $this->getServer()->getCommandMap()->register("StaffChat", new StaffChatCommand("staffchat", "Write something in the Staff Chat", null, ["sc"]));
        $this->getServer()->getPluginManager()->registerEvents(new PlayerJoinListener(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new PlayerQuitListener(), $this);
    }

    public function getConfig(): Config {
        return new Config($this->getDataFolder() . "config.yml", Config::YAML);
    }

    public function isStaffMember(Player $player): bool {
        if (!array_key_exists($player->getName(), $this->onlineStaffMembers)) {
            return false;
        }
        return true;
    }

    public function addOnlineStaffMember(Player $player): void {
        $this->onlineStaffMembers[$player->getName()] =  true;
    }

    public function removeOnlineStaffMember(Player $player): void {
        unset($this->onlineStaffMembers[$player->getName()]);
    }

    public function sendMessage(string $message):  void {
        $loader = StaffChat::getInstance();
        foreach ($loader->getServer()->getOnlinePlayers() as $player) {
            if ($this->isStaffMember($player)) {
                $player->sendMessage($message);
            }
        }
    }
}
