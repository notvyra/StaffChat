<?php

namespace LUKAY\StaffChat\listener;

use LUKAY\StaffChat\StaffChat;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;

class PlayerQuitListener implements Listener {

    public function onQuit(PlayerQuitEvent $event): void {
        $player = $event->getPlayer();
        $staffchat = StaffChat::getInstance();
        if ($staffchat->isStaffMember($player)) {
            $staffchat->removeOnlineStaffMember($player);
        }
    }
}
