<?php

namespace m039;

require __DIR__ . '/../vendor/autoload.php';

use m039\DB\DBManager;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Configuration;
use SergiX44\Nutgram\RunningMode\Webhook;

$config = Config::findConfig();
if (!$config) {
    die("Can't find a config.\n");
}

$db = DBManager::createInstance($config);

$bot = new Nutgram($config->get("TOKEN"), new Configuration(enableHttp2: false));

$webhook = new Webhook(secretToken: $config->get("WEBHOOK_SECRET"));
$webhook->setSafeMode(true);
$bot->setRunningMode($webhook);

$bot->onCommand('start', function(Nutgram $bot) {
    $bot->sendMessage('Присылайте сообщение боту и он отправит вам его обратно.');
});

$bot->onUpdate(function (Nutgram $bot) {
    global $db;

    $db->insertOrUpdateEntry($bot->userId(), $bot->chatId(), $bot->message()->getText(), $bot->user()->first_name);

    $text = $bot->message()->getText();
    if (strpos($text, "/start") === 0) {
        return;
    }
    
    $bot->sendMessage($text);
});

$bot->run();

echo "Ok.\n";