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
        $staffchat = StaffChat::getInstance();
        if (!$sender instanceof Player) {
            $sender->sendMessage($staffchat->getConfig()->get("executor-not-player"));
            return;
        }

        if (!$this->testPermission($sender)) {
            return;
        }

        if (empty($args[0])) {
            $sender->sendMessage($staffchat->getConfig()->get("no-message-specified"));
            return;
        }

        if ($staffchat->getConfig()->get("webhook") === true) {
            $staffchat->sendMessage(str_replace(["{player}", "{message}"] ,[$sender->getName(), implode(" ", $args)], $staffchat->getConfig()->get("chat-design")));
            $staffchat->sendMessageToDiscord($sender, implode(" ", $args));
        } else {
            $staffchat->sendMessage(str_replace(["{player}", "{message}"] ,[$sender->getName(), implode(" ", $args)], $staffchat->getConfig()->get("chat-design")));
        }
    }
}