# Secupay Transaction Flagging API

## Project Overview

This is a specialized API service that manages transaction flags (called "flagbits") for financial transactions. The system allows authorized users to add or remove status indicators to transactions, providing a way to mark transactions with specific attributes such as "verified", "suspicious", or "pending review".

## What This Application Does

This application provides a secure way to:

1. **View active flags** on any transaction (with proper authorization)
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

- **Input Validation**: All user inputs are validated against strict rules before processing
- **Parameter Sanitization**: Input parameters are sanitized to prevent SQL injection and other attacks
- **Rate Limiting**: API endpoints are protected against abuse with configurable rate limiting
- **CORS Protection**: Cross-Origin Resource Sharing policies are properly configured
- **JSON Encoding**: All responses use properly encoded JSON with appropriate HTTP status codes

## Error Reporting & Logging

- **Structured Error Responses**: All API errors return a consistent JSON structure with proper HTTP status codes
- **Detailed Logging**: Application errors are logged with detailed context information using Monolog
- **Exception Handling**: Custom exception handlers capture and report errors appropriately
- **Monitoring**: Integration with monitoring systems for real-time error alerting
- **Audit Trail**: Critical operations are logged with user information for audit purposes

## Coding Style & Standards

- **PSR Standards**: Code follows PSR-1, PSR-4, and PSR-12 coding standards
- **Type Hinting**: Strict type declarations are used throughout the codebase
- **Documentation**: All classes and methods include PHPDoc blocks
- **Automated Testing**: Comprehensive test suite using PHPUnit, Codeception, and Behat
- **Code Quality Tools**: Utilizes static analysis tools for maintaining code quality
- **Dependency Management**: Composer for managing PHP dependencies

## Getting Started

Please see [INSTALL.md](INSTALL.md) for detailed installation instructions.

## Testing

This project includes automated tests using Codeception. Run tests with:

```bash
php artisan test
```

or

```bash
vendor/bin/codecept run
```

