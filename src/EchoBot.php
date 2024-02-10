<?php

namespace m039;

require __DIR__ . '/../vendor/autoload.php';

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Configuration;
use SergiX44\Nutgram\RunningMode\Webhook;

$config = Config::findConfig();
if (!$config) {
    die("Can't find a config.\n");
}

$bot = new Nutgram($config->get("TOKEN"), new Configuration(enableHttp2: false));

$webhook = new Webhook(secretToken: $config->get("WEBHOOK_SECRET"));
$webhook->setSafeMode(true);
$bot->setRunningMode($webhook);

$bot->onCommand('start', function(Nutgram $bot) {
    $bot->sendMessage('Присылайте сообщение боту и он отправит вам его обратно.');
});

$bot->onText("*", function (Nutgram $bot, string $text) {
    $bot->sendMessage($text);
});

$bot->run();