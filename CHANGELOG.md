# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

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
