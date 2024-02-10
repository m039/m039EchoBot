<?php

namespace m039\DB;

use m039\Config;
use PDO;

class DBManager {
    private PDO $connection;

    private function __construct(string $filepath) {
        $this->connection = new PDO("sqlite:$filepath");
        $this->createTables();
    }

    private function createTables() {
        $this->connection->exec("CREATE TABLE IF NOT EXISTS echo_bot (
                user_id INTEGER NOT NULL,
                chat_id INTEGER NOT NULL,
                message TEXT,
                user_name TEXT,
                PRIMARY KEY (user_id, chat_id)
            )");
    }

    public function insertOrUpdateEntry(int $userId, int $chatId, string | null $message, string | null $userName) {
        $statement = $this->connection->prepare("INSERT OR IGNORE INTO echo_bot(user_id, chat_id, message, user_name) VALUES(:user_id, :chat_id, :message, :user_name)");
        $values = [
            ":user_id" => $userId,
            ":chat_id" => $chatId,
            ":message" => $message,
            ":user_name" => $userName
        ];
        $statement->execute($values);

        $statement = $this->connection->prepare("UPDATE echo_bot SET message = :message, user_name = :user_name WHERE user_id=:user_id AND chat_id=:chat_id");
        $statement->execute($values);
    }

    public static function createInstance(Config $config) : DBManager {
        if (!$config) {
            die("Can't create the database manager.");
        }

        $sqlite = $config->get("SQLITE_DATABASE");
        if (!$sqlite) {
            die("No SQLITE_DATABASE key in the config.");
        }

        $dirname = dirname($sqlite);
        if (!is_dir($dirname)) {
            mkdir($dirname, recursive: true);
        }

        return new DBManager($sqlite);
    }
}