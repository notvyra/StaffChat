<?php

namespace LUKAY\StaffChat\tasks;

use pocketmine\scheduler\AsyncTask;

class SendAsyncTask extends AsyncTask {

    protected string $username;
    protected string $message;
    protected string $url;

    public function __construct(string $username, string $message, string $url) {
        $this->username = $username;
        $this->message = $message;
        $this->url = $url;
    }

    public function onRun(): void {
        $data = json_encode
        ([
            "content" => $this->message,
            "username" => $this->username,
        ], JSON_UNESCAPED_SLASHES, JSON_UNESCAPED_UNICODE);
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_exec($ch);
        curl_close($ch);
    }
}