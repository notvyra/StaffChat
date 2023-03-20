<?php

namespace LUKAY\StaffChat\listener;

use LUKAY\StaffChat\StaffChat;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;

class PlayerChatListener implements Listener {

    public function onChat(PlayerChatEvent $event): void {
        $player = $event->getPlayer();
        $staffchat = StaffChat::getInstance();
        if ($staffchat->getConfig()->get("webhook") === true && str_starts_with($event->getMessage(), $staffchat->getConfig()->get("staffchat-use-prefix")) && $player->hasPermission("ultrastaffchat.bypass")) {
            $staffchat->sendMessage(str_replace(["{player}", "{message}"] ,[$player->getName(), $event->getMessage()], $staffchat->getConfig()->get("chat-design")));
            $staffchat->sendMessageToDiscord($player, $event->getMessage());
            $event->cancel();
        } elseif ($staffchat->getConfig()->get("webhook") === false && str_starts_with($event->getMessage(), $staffchat->getConfig()->get("staffchat-use-prefix")) && $player->hasPermission("ultrastaffchat.bypass")) {
            $staffchat->sendMessage(str_replace(["{player}", "{message}"] ,[$player->getName(), $event->getMessage()], $staffchat->getConfig()->get("chat-design")));
            $event->cancel();
        }
    }
}