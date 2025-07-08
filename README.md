# Secucard Transaction Flagging API

## About This Project

This is a Laravel-based API solution developed as part of the PHP backend developer technical assessment for secucard GmbH. The implementation demonstrates handling of database interactions with stored procedures, RESTful API design, comprehensive testing, and security best practices.
## Project Overview

This is a specialized API service that manages transaction flags (called "flagbits") for financial transactions. The system allows authorized users to add or remove status indicators to transactions, providing a way to mark transactions with specific attributes such as "verified", "suspicious", or "pending review".

## What This Application Does

This application provides a secure way to:

1. **View active flags** on any transaction of the user matching the API key
2. **View flag history** to see when flags were added or removed from transactions
3. **Set new flags** on transactions (requires elevated permissions)
4. **Remove flags** from transactions (requires elevated permissions)

## Technical Architecture

This is a PHP application built using the Laravel framework (v12.19.3), but configured specifically as an API-only service (no frontend). The application follows a modern, layered architecture pattern.

### Key Components

- **API Keys**: All requests require API key authentication
- **Database Integration**: The system interacts with a MySQL database that stores transaction records, flagbits, and time periods
- **Stored Procedures**: Uses database stored procedures for critical operations like setting/removing flags
- **Temporal Data**: Maintains historical records of all flagbit changes with effective time periods

## Database Schema

The application works with the following key tables:
- `api_apikey` - Stores API access tokens
- `vorgaben_zeitraum` - Time period specifications for validation
- `transaktion_transaktionen` - Transaction records
- `stamd_flagbit_ref` - FlagBit references for transactions
- `vorgaben_flagbit` - List of possible FlagBits
- 
### Application Structure

- **Controllers**: Handle incoming HTTP requests and return appropriate responses
- **Middleware**: Manages request authentication, validation, and preprocessing
- **Services**: Contains the core business logic separated from controllers
- **Models**: Represents database entities and their relationships
- **Repositories**: Abstracts database operations away from the service layer
- **Events & Listeners**: Implements event-driven architecture for certain operations
- **Jobs & Queues**: Handles asynchronous processing using database queue driver

## API Endpoints

The API provides these main endpoints:

- `GET /api/v1/flagbits/active` - Get all active flags for a transaction
- `GET /api/v1/flagbits/history` - Get the complete flag history for a transaction
- `POST /api/v1/flagbits/set` - Add a new flag to a transaction (requires master API key)
- `DELETE /api/v1/flagbits/remove` - Remove a flag from a transaction (requires master API key)
- `GET /api/v1/time` - Get the current server time

Please see [API.md](API.md) for detailed information.

## Security Model

The system implements a tiered security approach:

1. **Basic Authentication**: All requests require a valid API key
2. **Contract Verification**: API keys are tied to specific contracts, preventing access to transactions from other contracts
3. **Permission Levels**: Some operations (like setting/removing flags) require elevated permissions via a master API key

### Authentication & Authorization

- **API Key Authentication**: All API endpoints (except documentation) are protected by API key authentication via the `ApiKeyAuth` middleware
- **Role-Based Access Control**: Different API keys have different permission levels (standard vs. master)
- **Request Validation**: All incoming requests are validated for required parameters and proper formatting
- **Token Management**: API keys are securely stored with hashing and have configurable expiration

### Request & Response Security

- **Input Validation**: Implemented using Laravel's built-in `Validator` facade and custom Form Request classes. Validation rules are defined for every endpoint to ensure all incoming data adheres to the required format, type, and constraints before being processed by the application logic.

- **Parameter Sanitization & SQL Injection Prevention**: The application relies on Laravel's Eloquent ORM, which uses PDO parameter binding to automatically protect against SQL injection attacks. No raw SQL queries are used for operations involving user-provided data. Additional sanitization is performed for any data that might be rendered in logs or other outputs.

- **Rate Limiting**: API endpoints are protected against brute-force attacks and abuse using Laravel's built-in rate limiting middleware. The rate limiter, named `api`, is configured in `app/Providers/AppServiceProvider.php` and applied to API routes. By default, it allows 60 requests per minute, identified by the authenticated user's ID or the requester's IP address.

- **Secure Headers & JSON Encoding**: All API responses are sent as `JsonResponse` objects, which automatically set the `Content-Type` header to `application/json` and handle proper JSON encoding. Additional security headers (like `X-Content-Type-Options`, `X-Frame-Options`, etc.) can be configured via middleware to protect against common web vulnerabilities like clickjacking.

## Error Reporting & Logging

- **Structured Error Responses**: All API errors return a consistent JSON structure with proper HTTP status codes
- **Detailed Logging**: Application errors are logged with detailed context information
- **Exception Handling**: Custom exception handlers capture and report errors appropriately

## Coding Style & Standards

- **Code Style**: The codebase adheres to the PSR-12 coding standard. Compliance is automatically enforced using Laravel Pint.
- **Modern PHP**: The project leverages modern PHP 8.x features, including strict type declarations for properties, parameters, and return types. This enhances code reliability and clarity.
- **Self-Documenting Code**: **The code is written to be self-explanatory, using clear and descriptive naming for classes, methods, and variables. This approach avoids the verbosity of PHPDoc blocks and relies on the language's type system for documentation.**
- **Automated Testing**: The project has a comprehensive test suite using Laravel PHPUnit integration to ensure code quality and reliability.
- **Dependency Management**: PHP dependencies are managed using Composer.

## Getting Started

Please see [INSTALL.md](INSTALL.md) for detailed installation instructions.

## Testing

### Automatic Testing
This project includes automated PhpUnit unit and Http/Feature tests. Run tests after installation with:

```bash
vendor/bin/sail artisan test
```

### API Usage

Import the Postman collection from `postman/Laravel_API_Challenge.postman_collection.json` for immediate testing.

Sample API keys available after Seeding the database - see [INSTALL.md](INSTALL.md) for details
