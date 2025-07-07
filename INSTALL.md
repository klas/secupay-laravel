# Installation Guide

## Quick Installation

1. **Clone/Download the project**
2. **Run setup scripts:**
   ```bash
   chmod +x *.sh
   ./setup-complete-project.sh
   ./create-models.sh
   ./create-migrations.sh
   ./create-seeders.sh
   ./create-tests.sh
   ./create-additional-files.sh
   ```

3. **Configure environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Setup database:**
   - Configure database settings in `.env`
   - Run: `php artisan migrate --seed`

5. **Start development server:**
   ```bash
   php artisan serve
   ```

## Manual Installation

If you prefer to create files manually, follow the README.md instructions.

## Docker Installation

```bash
docker-compose up -d
docker-compose exec app composer install
docker-compose exec app php artisan migrate --seed
```

## Testing

```bash
# PHPUnit tests
php artisan test

# Codeception tests (after setup)
vendor/bin/codecept run
```

## API Usage

Import the Postman collection from `postman/Laravel_API_Challenge.postman_collection.json` for immediate testing.

Sample API keys:
- Regular: `9faa37b23f350c516e3589e60083d10cd368df01`
- Master: `8067562d7138d72501485941246cf9b229c3a46a`
