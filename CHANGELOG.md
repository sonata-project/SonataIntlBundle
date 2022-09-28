# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [3.0.1](https://github.com/sonata-project/SonataIntlBundle/compare/3.0.0...3.0.1) - 2022-09-27
### Fixed
- [[#560](https://github.com/sonata-project/SonataIntlBundle/pull/560)] All the templates using `sonata_number_format_*` methods ([@VincentLanglet](https://github.com/VincentLanglet))

## [3.0.0](https://github.com/sonata-project/SonataIntlBundle/compare/3.0.0-alpha-2...3.0.0) - 2022-08-16
### Added
- [[#547](https://github.com/sonata-project/SonataIntlBundle/pull/547)] Added support for `symfony/translation-contracts` ^3 ([@AirBair](https://github.com/AirBair))

## [3.0.0-alpha-2](https://github.com/sonata-project/SonataIntlBundle/compare/3.0.0-alpha-1...3.0.0-alpha-2) - 2022-08-07
### Fixed
- [[#542](https://github.com/sonata-project/SonataIntlBundle/pull/542)] Add missing kernel.local_aware dependency injection container tags for definitions that implement symfony's LocaleAwareInterface. ([@temp](https://github.com/temp))

## [3.0.0-alpha-1](https://github.com/sonata-project/SonataIntlBundle/compare/2.x...3.0.0-alpha-1) - 2022-08-07
### Added
- [[#539](https://github.com/sonata-project/SonataIntlBundle/pull/539)] Final keyword to all classes ([@VincentLanglet](https://github.com/VincentLanglet))
- [[#539](https://github.com/sonata-project/SonataIntlBundle/pull/539)] Typehint to all methods ([@VincentLanglet](https://github.com/VincentLanglet))

## [2.14.0](https://github.com/sonata-project/SonataIntlBundle/compare/2.13.1...2.14.0) - 2022-08-16
### Added
- [[#547](https://github.com/sonata-project/SonataIntlBundle/pull/547)] Added support for `symfony/translation-contracts` ^3 ([@AirBair](https://github.com/AirBair))

## [2.13.1](https://github.com/sonata-project/SonataIntlBundle/compare/2.13.0...2.13.1) - 2022-08-09
### Fixed
- [[#542](https://github.com/sonata-project/SonataIntlBundle/pull/542)] Add missing kernel.local_aware dependency injection container tags for definitions that implement symfony's LocaleAwareInterface. ([@temp](https://github.com/temp))

## [2.13.0](https://github.com/sonata-project/SonataIntlBundle/compare/2.12.1...2.13.0) - 2022-08-05
### Changed
- [[#520](https://github.com/sonata-project/SonataIntlBundle/pull/520)] Make `Symfony/Templating` Component optional ([@Hanmac](https://github.com/Hanmac))

### Deprecated
- [[#520](https://github.com/sonata-project/SonataIntlBundle/pull/520)] Deprecated the Templating\Helper classes ([@Hanmac](https://github.com/Hanmac))
- [[#520](https://github.com/sonata-project/SonataIntlBundle/pull/520)] Deprecated the use of the Templating\Helper classes inside the Twig Runtime and Extensions ([@Hanmac](https://github.com/Hanmac))
- [[#520](https://github.com/sonata-project/SonataIntlBundle/pull/520)] Deprecated uses of LocaleDetectorInterface in favor of Symfony\Contracts\Translation\LocaleAwareInterface ([@Hanmac](https://github.com/Hanmac))

### Removed
- [[#525](https://github.com/sonata-project/SonataIntlBundle/pull/525)] Remove support for PHP 7.3 ([@jordisala1991](https://github.com/jordisala1991))
- [[#524](https://github.com/sonata-project/SonataIntlBundle/pull/524)] Support of Symfony 5.3 ([@franmomu](https://github.com/franmomu))

## [2.12.1](https://github.com/sonata-project/SonataIntlBundle/compare/2.12.0...2.12.1) - 2022-04-11
### Fixed
- [[#514](https://github.com/sonata-project/SonataIntlBundle/pull/514)] Missing service declarations for Runtime services ([@VincentLanglet](https://github.com/VincentLanglet))

## [2.12.0](https://github.com/sonata-project/SonataIntlBundle/compare/2.11.2...2.12.0) - 2022-04-09
### Added
- [[#512](https://github.com/sonata-project/SonataIntlBundle/pull/512)] -`sonata_format_date` filter ([@VincentLanglet](https://github.com/VincentLanglet))
- [[#512](https://github.com/sonata-project/SonataIntlBundle/pull/512)] -`sonata_format_time` filter ([@VincentLanglet](https://github.com/VincentLanglet))
- [[#512](https://github.com/sonata-project/SonataIntlBundle/pull/512)] -`sonata_format_datetime` filter ([@VincentLanglet](https://github.com/VincentLanglet))
- [[#512](https://github.com/sonata-project/SonataIntlBundle/pull/512)] -`sonata_number_format_*` filters ([@VincentLanglet](https://github.com/VincentLanglet))
- [[#512](https://github.com/sonata-project/SonataIntlBundle/pull/512)] -`sonata_country` filter ([@VincentLanglet](https://github.com/VincentLanglet))
- [[#512](https://github.com/sonata-project/SonataIntlBundle/pull/512)] -`sonata_locale` filter ([@VincentLanglet](https://github.com/VincentLanglet))
- [[#512](https://github.com/sonata-project/SonataIntlBundle/pull/512)] -`sonata_language` filter ([@VincentLanglet](https://github.com/VincentLanglet))

### Deprecated
- [[#512](https://github.com/sonata-project/SonataIntlBundle/pull/512)] -`format_date` filter ([@VincentLanglet](https://github.com/VincentLanglet))
- [[#512](https://github.com/sonata-project/SonataIntlBundle/pull/512)] -`format_time` filter ([@VincentLanglet](https://github.com/VincentLanglet))
- [[#512](https://github.com/sonata-project/SonataIntlBundle/pull/512)] -`format_datetime` filter ([@VincentLanglet](https://github.com/VincentLanglet))
- [[#512](https://github.com/sonata-project/SonataIntlBundle/pull/512)] -`number_format_*` filters ([@VincentLanglet](https://github.com/VincentLanglet))
- [[#512](https://github.com/sonata-project/SonataIntlBundle/pull/512)] -`country` filter ([@VincentLanglet](https://github.com/VincentLanglet))
- [[#512](https://github.com/sonata-project/SonataIntlBundle/pull/512)] -`locale` filter ([@VincentLanglet](https://github.com/VincentLanglet))
- [[#512](https://github.com/sonata-project/SonataIntlBundle/pull/512)] -`language` filter ([@VincentLanglet](https://github.com/VincentLanglet))

## [2.11.2](https://github.com/sonata-project/SonataIntlBundle/compare/2.11.1...2.11.2) - 2021-11-20
### Fixed
- [[#488](https://github.com/sonata-project/SonataIntlBundle/pull/488)] Correctly default to the kernel default locale when no locale is provided. ([@VincentLanglet](https://github.com/VincentLanglet))

## [2.11.1](https://github.com/sonata-project/SonataIntlBundle/compare/2.11.0...2.11.1) - 2021-11-06
### Fixed
- [[#482](https://github.com/sonata-project/SonataIntlBundle/pull/482)] Fixed service registration ([@core23](https://github.com/core23))

## [2.11.0](https://github.com/sonata-project/SonataIntlBundle/compare/2.10.2...2.11.0) - 2021-11-06
### Added
- [[#477](https://github.com/sonata-project/SonataIntlBundle/pull/477)] Added PHPStan and Psalm ([@jordisala1991](https://github.com/jordisala1991))
- [[#475](https://github.com/sonata-project/SonataIntlBundle/pull/475)] Added some Symfony 6 support ([@Kocal](https://github.com/Kocal))

## [2.10.2](https://github.com/sonata-project/SonataIntlBundle/compare/2.10.1...2.10.2) - 2021-08-05
### Fixed
- [[#430](https://github.com/sonata-project/SonataIntlBundle/pull/430)] Fixed `NumberFormatter::format(): Argument #1 ($num) must be of type int|float, string given`. ([@nocive](https://github.com/nocive))

## [2.10.1](https://github.com/sonata-project/SonataIntlBundle/compare/2.10.0...2.10.1) - 2021-02-15
### Changed
- [[#397](https://github.com/sonata-project/SonataIntlBundle/pull/397)] Use existing `get_admin_template` twig method to get parent templates ([@toooni](https://github.com/toooni))

### Fixed
- [[#397](https://github.com/sonata-project/SonataIntlBundle/pull/397)] Fixes compatibility with the 4.x branch of SonataAdminBundle ([@toooni](https://github.com/toooni))

## [2.10.0](https://github.com/sonata-project/SonataIntlBundle/compare/2.9.0...2.10.0) - 2020-12-01
### Added
- [[#367](https://github.com/sonata-project/SonataIntlBundle/pull/367)] Added support for PHP 8. ([@franmomu](https://github.com/franmomu))

## [2.9.0](https://github.com/sonata-project/SonataIntlBundle/compare/2.8.0...2.9.0) - 2020-08-09
### Added
- [[#312](https://github.com/sonata-project/SonataIntlBundle/pull/312)] Added support for symfony/template 5.1 ([@franmomu](https://github.com/franmomu))

## [2.8.0](https://github.com/sonata-project/SonataIntlBundle/compare/2.7.0...2.8.0) - 2020-07-30
### Added
- [[#308](https://github.com/sonata-project/SonataIntlBundle/pull/308)] Added
  support for Symfony 5 ([@jordisala1991](https://github.com/jordisala1991))
- [[#308](https://github.com/sonata-project/SonataIntlBundle/pull/308)] Added
  support for Twig 3 ([@jordisala1991](https://github.com/jordisala1991))
- [[#306](https://github.com/sonata-project/SonataIntlBundle/pull/306)] Added
  support for "symfony/intl:^5". ([@phansys](https://github.com/phansys))
- [[#300](https://github.com/sonata-project/SonataIntlBundle/pull/300)] Added
  `TimezoneAwareInterface` interface and `TimezoneAwareTrait` trait.
([@phansys](https://github.com/phansys))

### Changed
- [[#282](https://github.com/sonata-project/SonataIntlBundle/pull/282)] Bump SF
  to 4.4 ([@bmaziere](https://github.com/bmaziere))
- [[#279](https://github.com/sonata-project/SonataIntlBundle/pull/279)] Do not
  resolve the `kernel.default_locale` parameter when configuring the locale in
the bundle extension. ([@fancyweb](https://github.com/fancyweb))

### Deprecated
- [[#300](https://github.com/sonata-project/SonataIntlBundle/pull/300)]
  Deprecated timezone inference based on
`Sonata\UserBundle\Model\User::getTimezone()`.
([@phansys](https://github.com/phansys))

### Fixed
- [[#304](https://github.com/sonata-project/SonataIntlBundle/pull/304)] Fixed
  exception thrown when calling `self::expectDeprecation()` from the test
suite. ([@phansys](https://github.com/phansys))

### Removed
- [[#300](https://github.com/sonata-project/SonataIntlBundle/pull/300)] Removed
  dependency suggestion against "sonata-project/user-bundle".
([@phansys](https://github.com/phansys))
- [[#272](https://github.com/sonata-project/SonataIntlBundle/pull/272)] Support
  for Symfony < 3.4 ([@franmomu](https://github.com/franmomu))
- [[#272](https://github.com/sonata-project/SonataIntlBundle/pull/272)] Support
  for Symfony >= 4, < 4.2 ([@franmomu](https://github.com/franmomu))

## [2.7.0](https://github.com/sonata-project/SonataIntlBundle/compare/2.6.0...2.7.0) - 2019-08-08

### Fixed
- Restore backward compatibility by accepting currency values represented as string.
- deprecation notice about using namespaced classes from `\Twig\`

### Changed

- Bumped "twig/twig" dependency to "^2.9";
- Changed usages of `{% spaceless %}` tag, which is deprecated as of Twig 1.38 with `{% apply spaceless %}` filter;
- Changed the rendering for the audit revision timestamp in order to use
  `<time>` tags, which print the dates in UTC using `datetime` and `title`
attributes, allowing to view the UTC date with the default browser tooltip.

## [2.6.0](https://github.com/sonata-project/SonataIntlBundle/compare/2.5.0...2.6.0) - 2019-05-02
### Fixed
- Fix deprecation for symfony/config 4.2+

### Changed
- Changed the rendering for date, datetime and time properties in order to use
  `<time>` tags, which print the dates in UTC using `datetime` and `title`
attributes, allowing to view the UTC date with the default browser tooltip.

### Removed
- support for php 5 and php 7.0

## [2.5.0](https://github.com/sonata-project/SonataIntlBundle/compare/2.4.1...2.5.0) - 2018-06-16
### Added
- Improved autowiring support for templating helpers

## [2.4.1](https://github.com/sonata-project/SonataIntlBundle/compare/2.4.0...2.4.1) - 2018-05-05
### Fixed
- Compatibilty with Symfony 4: services are now public

### Changed
- All templates references are updated to twig namespaced syntax

## [2.4.0](https://github.com/sonata-project/SonataIntlBundle/compare/2.3.2...2.4.0) - 2017-11-30
### Removed
- support for old versions of php and Symfony

### Fixed
- It is now allowed to install Symfony 4

## [2.3.2](https://github.com/sonata-project/SonataIntlBundle/compare/2.3.1...2.3.2) - 2017-09-14
### Added
- Added compatiblity with SonataUserBundle 4

## [2.3.1](https://github.com/sonata-project/SonataIntlBundle/compare/2.3.0...2.3.1) - 2017-06-27
### Fixed
- Deprecated fixed strict service parameter usage

## [2.3.0](https://github.com/sonata-project/SonataIntlBundle/compare/2.2.4...2.3.0) - 2017-01-17
### Added
- Added support for `\DateTimeImmutable`
- Compatibility with Twig 2.0
