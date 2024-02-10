# m039EchoBot
## About

The address of the bot is [@m039EchoBot](https://t.me/m039EchoBot).

## Installation

```bash
cd <project-directory>

# Install dependencies.
composer install

# Add configuration parameters.
echo "TOKEN=..." > .config.ini
echo "WEBHOOK_SECRET=..." >> .config.ini
echo "SQLITE_DATABASE=..." >> .config.ini # Absolute paths only
echo "LOGFILE=..." >> .config # Absolute paths only. Can be omitted.

# Set the webhook url.
composer setup-webhook --set "..."

```