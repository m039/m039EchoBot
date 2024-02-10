<?php

namespace m039\Commands;

require_once __DIR__ . '/../../vendor/autoload.php';

use m039\Config;
use SergiX44\Nutgram\Configuration;
use SergiX44\Nutgram\Nutgram;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SetupWebhookCommand extends Command {

    protected function configure(): void
    {
        $this->addOption("set", null, InputOption::VALUE_REQUIRED, "Set a webhook url.");
        $this->addOption("unset", null, InputOption::VALUE_NONE, "Unset the webhook's url.");
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $config = Config::findConfig();
        $bot = new Nutgram($config->get("TOKEN"), new Configuration(enableHttp2: false));

        if ($input->getOption("unset")) {
            $bot->deleteWebhook();
            $output->writeln("The webhook is unset.");
            return Command::SUCCESS;
        }

        $url = $input->getOption("set");

        if ($url) {
            $bot->setWebhook($url, secret_token: $config->get("WEBHOOK_SECRET"));
            $output->writeln('The webhook is set to ' . $url . '.');
            return Command::SUCCESS;
        }

        return Command::FAILURE;
    }
}