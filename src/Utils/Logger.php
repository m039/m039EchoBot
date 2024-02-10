<?php

namespace m039\Utils;

use m039\Config;

class Logger {
    private string $logfile;

    public function __construct(string | null $logfile) {
        $this->logfile = $logfile;
    }

    public function log(string $message) {
        if ($this->logfile) {
            error_log($message, 3, $this->logfile);
        }
    }

    public static function createInstance(Config $config) : Logger {
        if (!$config) {
            return new Logger(null);
        }

        $logfile = $config->get("LOGFILE");
        if (!$logfile) {
            return new Logger(null);
        }

        return new Logger($logfile);
    }
}