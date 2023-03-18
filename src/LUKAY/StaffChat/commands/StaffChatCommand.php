<?php

namespace LUKAY\StaffChat\commands;

use LUKAY\StaffChat\StaffChat;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;

class StaffChatCommand extends Command implements PluginOwned {

    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = []) {
        $this->setPermission("staffchat.bypass");
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function getOwningPlugin(): Plugin {
        return StaffChat::getInstance();
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        $staffchat = $this->getOwningPlugin();
        if (!$sender instanceof Player) {
            $sender->sendMessage("You cannot run this command from the console");
            return;
        }

        if (!$this->testPermission($sender)) {
            $sender->sendMessage("You don't have access to Staff Chat");
            return;
        }

        if (empty($args[0])) {
            $sender->sendMessage("You didn't specify a message to send");
            return;
        }
        $staffchat->sendMessage("§6§lStaffChat §r§7| " . implode(" ", $args));
    }
}
