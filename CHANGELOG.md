# Changelog
All notable changes to this project will be documented in this file.

## [1.1.5] - 2017-06-26

### Added
- PHP 7 and Contao 4 support

## [1.1.4] - 2017-03-20

### Fixed
- replaced missing method call `NotificationCenterPlus::createSalutation()` with `HeimrichHannot\Haste\Util\Salutations::createSalutation()`

## [1.1.3] - 2017-03-20

### Changed
- fixed published check

## [1.1.2] - 2017-03-20

### Changed
- localization

## [1.1.1] - 2017-03-20

### Changed
- Observer::getPalettes() is not abstract anymore since not every observer has to have config fields

## [1.1.0] - 2017-03-20

### Added
- German localization
- STATES can now be overridden in Observer subclasses

### Fixed
- manager has now .php extension since it's a php file -> rename your CRONs if set
- interface is now named more understandable
- refactoring
- changed array() to []
- history icon
