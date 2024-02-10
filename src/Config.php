<?php 

namespace m039;

class Config {
    private const FILENAME = ".config.ini";

    private array $config = [];

    private function __construct(string $filepath) {
        $this->readFile($filepath);
    }

    public function get(string $key) : string | null {
        if (!array_key_exists($key, $this->config)) {
            return null;
        }

        return $this->config[$key];
    }

    private function readFile(string $filepath) {
        $fp = @fopen($filepath, "r");
        if (!$fp) {
            die("Can't open the file: " . $filepath . "\n");
        }

        while (($buffer = fgets($fp)) !== false) {
            $position = strpos($buffer, "=");
            if (!$position) {
                continue;
            }

            $value = trim(substr($buffer, $position + 1));
            if (strlen($value) >= 3 && $value[0] === '"' && $value[strlen($value) - 1] === '"') {
                $value = substr($value,1,-1);
            }

            $this->config[substr($buffer, 0, $position)] = $value;
        }

        if (!feof($fp)) {
            die("Error: can't read the file's content.");
        }

        fclose($fp);
    }

    public static function findConfig(string $filename = null) : Config | null {
        if (!$filename) {
            $filename = Config::FILENAME;
        }

        $finder = function (string $directory) use (&$finder, $filename) : string | null {
            $filepath = $directory . "/" . $filename;
            if (file_exists($filepath)) {
                return $filepath;
            }

            $newDirectory = dirname($directory);
            if ($newDirectory == $directory) {
                return null;
            }

            return $finder($newDirectory);
        };

        $filepath = $finder(__DIR__);
        if (!$filepath) {
            return null;
        }

        return new Config($filepath);
    }

}