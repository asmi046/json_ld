# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [0.1.0] - 2026-04-09

### Added

- Initial release of the package
- Fluent Builder API for creating JSON-LD entities
- Factory/make() method for creating entities by type
- Support for 5 schema types: Person, Organization, Article, Product, WebSite
- Strict validation mode with detailed error messages
- Multiple output formats: render() as HTML script tag, toJson(), toArray()
- Blade directive integration (@jsonld)
- Helper functions: jsonld_person(), jsonld_organization(), etc.
- Configuration options for strict mode, pretty printing, and escape mode
- Orchestra Testbench integration for testing
- PHPStan static analysis support
- MIT License
- Comprehensive README with examples
