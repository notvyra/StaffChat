<?php

namespace LUKAY\StaffChat\listener;

use LUKAY\StaffChat\StaffChat;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

class PlayerJoinListener implements Listener {

    public function onJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();
        $staffchat = StaffChat::getInstance();
        if ($player->hasPermission("ultrastaffchat.bypass")) {
            $staffchat->addOnlineStaffMember($player);
        }
    }
}