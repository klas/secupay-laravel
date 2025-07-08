# Installation Guide

## Quick Installation

* **Clone/Download the project**
* **Install dependencies:**
   ```bash
   docker run --rm -u "$(id -u):$(id -g)" -v "$(pwd):/var/www/html" -w /var/www/html laravelsail/php84-composer:latest composer install --ignore-platform-reqs
   ```
* If some Classes are missing: `docker run --rm --interactive --tty --volume $PWD:/app composer dump-autoload`
* **Configure the Environment:** copy .env-file: `cp .env.example .env`
* **Start the Containers**: `vendor/bin/sail up -d`
* **Run migrations und seeders**: `vendor/bin/sail artisan migrate:fresh --seed`

