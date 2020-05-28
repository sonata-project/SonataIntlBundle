UPGRADE 2.x
===========

UPGRADE FROM 2.7 to 2.8
=======================

### Timezone detector

``Sonata\IntlBundle\Timezone\TimezoneAwareInterface`` was added in order to provide
timezone detection for any user class.

Timezone inference based on the ``Sonata\UserBundle\Model\User::getTimezone()`` method
is deprecated and will be dropped in 3.0 version.
You MUST implement ``Sonata\IntlBundle\Timezone\TimezoneAwareInterface`` explicitly
in your user class.

Before:
```php
class User
{
    // ...
}
```

After:
```php
class User implements \Sonata\IntlBundle\Timezone\TimezoneAwareInterface
{
    // ...
}
```

UPGRADE FROM 2.3 to 2.4
=======================

### Tests

All files under the ``Tests`` directory are now correctly handled as internal test classes.
You can't extend them anymore, because they are only loaded when running internal tests.
More information can be found in the [composer docs](https://getcomposer.org/doc/04-schema.md#autoload-dev).
