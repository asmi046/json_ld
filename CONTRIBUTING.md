# Contributing to Laravel JSON-LD

Thank you for considering contributing to the Laravel JSON-LD package!

## Getting Started

1. Fork the repository
2. Clone your fork: `git clone https://github.com/asmi046/json_ld.git`
3. Create a feature branch: `git checkout -b feature/your-feature-name`
4. Install dependencies: `composer install`

## Development Setup

```bash
# Install dev dependencies
composer install

# Run tests
php vendor/bin/phpunit

# Run static analysis
php vendor/bin/phpstan analyse

# Check code style
php vendor/bin/pint
```

## Code Style

We follow PSR-12 coding standards. Use Laravel Pint to automatically fix style issues:

```bash
php vendor/bin/pint
```

## Testing

All new features must include tests:

```bash
# Run all tests
php vendor/bin/phpunit

# Run specific test
php vendor/bin/phpunit tests/Unit/EntityTest.php

# Run with coverage
php vendor/bin/phpunit --coverage-html coverage
```

## Pull Request Process

1. Update README.md and CHANGELOG.md with details of changes
2. Add tests for new functionality
3. Ensure all tests pass: `php vendor/bin/phpunit`
4. Ensure PHPStan analysis passes: `php vendor/bin/phpstan analyse`
5. Run Pint for code style: `php vendor/bin/pint`
6. Create a clear PR description explaining your changes

## Reporting Issues

Please report bugs using GitHub issues. Include:

- Description of the issue
- Steps to reproduce
- Expected vs actual behavior
- PHP and Laravel versions
- Any error messages or logs

## License

By contributing, you agree that your contributions will be licensed under the MIT License.
