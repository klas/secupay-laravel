# Installation Guide

## Requirements

- PHP ^8.x (8.4 will be used inside docker container)
- Docker Desktop (for Laravel Sail)
- Composer

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

## Test Data

After running migrations and seeders, the following test API keys are available:
- Regular API key: `9faa37b23f350c516e3589e60083d10cd368df01` (vertrag_id: 3)
- Master API key: `8067562d7138d72501485941246cf9b229c3a46a` (vertrag_id: 2, ist_masterkey: 1)
