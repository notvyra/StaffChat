<?php

namespace LUKAY\StaffChat\listener;

use LUKAY\StaffChat\StaffChat;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;

class PlayerChatListener implements Listener {

    public function onChat(PlayerChatEvent $event): void {
        $player = $event->getPlayer();
        $staffchat = StaffChat::getInstance();
        if (str_starts_with($event->getMessage(), $staffchat->getConfig()->get("staffchat-use-prefix")) && $player->hasPermission("staffchat.bypass")) {
            $staffchat->sendMessage(str_replace(["{player}", "{message}"] ,[$player->getName(), $event->getMessage()], $staffchat->getConfig()->get("chat-design")));
            $event->cancel();
        }
    }
}
