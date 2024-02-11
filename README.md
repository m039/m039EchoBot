# m039EchoBot
## About
A very basic Telegram bot that sends back what you've send to it. The purpose of it is to learn how the webhook feature of the Telegram bot API works.

The address of the bot is [@m039EchoBot](https://t.me/m039EchoBot).

The bot uses [Nutgram](https://github.com/nutgram/nutgram) and SQLite.

## Installation
```bash
cd <project-directory>

# Install dependencies.
composer install

# Add configuration parameters.
echo "TOKEN=..." > .config.ini
echo "WEBHOOK_SECRET=..." >> .config.ini
echo "SQLITE_DATABASE=..." >> .config.ini # Absolute paths only
echo "LOGFILE=..." >> .config.ini # Absolute paths only. Can be omitted.

# Set the webhook url.
composer setup-webhook --set "..."

```