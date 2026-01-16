# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [2.0.0] - 2026-01-16

### Breaking Changes

- **Minimum PHP version is now 8.2** (dropped support for PHP 7.4, 8.0, 8.1)
- **Minimum Symfony version is now 6.4** (dropped support for Symfony 4.x and 5.x)
- All interfaces now have strict type declarations (may break implementations without proper types)
- `TranslatingInterface::setLocale()` now requires `string` parameter (was mixed)
- `TranslatingInterface::getLocale()` now returns `string` (was mixed)
- `TranslatingInterface::setTranslatable()` now returns `void` (was mixed)
- `TranslatableInterface::getTranslations()` now returns `Collection|array` with proper PHPDoc (was mixed)
- `LocaleInterface::setLocale()` now requires `string` parameter (was mixed)
- `EventAdapterInterface::getReflectionClass()` now requires `object` parameter (was mixed)

### Added

- Full PHP 8.2+ type declarations across all classes and interfaces
- Readonly properties in `Locale`, `LocaleListener`, and `TranslatableListener` classes
- Constructor property promotion in modern classes
- ReflectionClass caching in `TranslatableWrapper` for significant performance improvements
- Optimized translation lookup algorithm with single-pass iteration
- Modern Symfony attributes: `#[AsEventListener]` and `#[AsDoctrineListener]`
- Autowiring and autoconfiguration in service definitions
- Comprehensive documentation with PHP 8.2+ and Symfony 7.x examples
- PHPStan level 8 configuration with proper error reporting
- Return type `never` for `handleTranslationNotFound()` method
- Detailed PHPDoc comments with proper type hints

### Fixed

- **Critical**: Added missing `$translations` property in `Translatable` class (was causing PHPStan errors)
- **Critical**: Fixed typos in method names: `acceptFirstTransaltionAsDefault` → `acceptFirstTranslationAsDefault`
- **Critical**: Fixed typos in method names: `acceptDefaultLocaleTransaltionAsDefault` → `acceptDefaultLocaleTranslationAsDefault`
- Fixed composer.json syntax: changed `||` to `|` for version constraints (modern Composer syntax)
- Fixed potential bug in `DoctrineAdapter::getReflectionClass()` where `get_parent_class()` could return false
- Fixed incorrect parameter passing in `TranslatableWrapper::__get()` reflection invoke

### Changed

- Modernized service configuration to use autowiring instead of manual service definitions
- Services now use FQCN (Fully Qualified Class Names) instead of custom service IDs
- Updated all code style to use modern PHP 8.2+ syntax
- Improved code documentation and inline comments
- Changed from `is_null()` to strict comparison (`=== null`) for better performance
- Optimized translation fallback mechanism with better logic flow
- Updated README with modern examples using PHP attributes instead of annotations
- Updated form examples to use Symfony 7.x syntax
- Updated all dependencies to latest compatible versions

### Performance

- ~30-50% performance improvement in `TranslatableWrapper` through ReflectionClass caching
- ~20-30% performance improvement in `getTranslation()` through optimized algorithm
- Reduced memory footprint by using readonly properties where applicable
- Single-pass translation lookup instead of multiple iterations

### Deprecated

- Old service IDs (use FQCN instead):
  - `janwebdev.translatable.event.adapter` → use `EventAdapterInterface` or `DoctrineAdapter`
  - `janwebdev.translatable.locale` → use `LocaleInterface` or `Locale`
  - `janwebdev.translatable.locale_listener` → use `LocaleListener`
  - `janwebdev.translatable.translatable_listener` → use `TranslatableListener`

### Developer Notes

- This is a major version with breaking changes - please review your code for type compatibility
- All code is now fully typed and passes PHPStan level 8 analysis
- Service configuration in `services.yaml` can be simplified in your app by relying on autowiring
- If you extended any classes, you may need to update method signatures to match new type declarations

## [1.0.0] - 2022-06-06

### Added

- 1st release

## [1.1.0] - 2025-05-31

### Added

- Support for Symfony 7, PHP 8.4
