Installation
============

This bundle requires the ``php-intl`` extension.

To begin, add the dependent bundle to the ``vendor/bundles`` directory.

If you use the Symfony's ``bin/vendor`` script, you can add a new entry in the deps file::

    [SonataIntlBundle]
        git=https://github.com/sonata-project/SonataIntlBundle
        target=/bundles/Sonata/IntlBundle

If using git, you can add them as submodules::

  git submodule add git://github.com/sonata-project/SonataIntlBundle.git vendor/bundles/Sonata/IntlBundle

Next, be sure to enable the bundles in your application kernel:

.. code-block:: php

  <?php
  // app/AppKernel.php
  public function registerBundles()
  {
      return array(
          // ...
          new Sonata\IntlBundle\SonataIntlBundle(),
          // ...
      );
  }

Configuration
-------------

You can configure the default timezone used by the date helper with the following configuration. By default the
``php.ini`` value is used (retrieved by the ``date_default_timezone_get()`` function). It is now possible to
configure your own service for timezone detecting or use the naive approach provided by this bundle. If you
configure your own service it should implement the ``Sonata\IntlBundle\Timezone\TimezoneDetectorInterface``.

The locale value used by the bundle is provided by the request.

Example using a custom service:

.. code-block:: yaml
    sonata_intl:
        timezone:
            service: my_custom_timezone_detector


Or the naive approach mapping the locales to timezones:

.. code-block:: yaml
    sonata_intl:
        timezone:
            # default timezone used as fallback
            default: Europe/Paris

            # locale specific overrides
            locales:
                fr: Europe/Paris
                en_UK: Europe/London

