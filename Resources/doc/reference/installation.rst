Installation
============

This bundle requires the ``php-intl`` extension.

To begin, add the dependent bundles::

    php composer.phar require sonata-project/intl-bundle

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
=============

To display dates, this bundle uses timezone detectors to get the
current timezone.


User timezone detector
----------------------

If the SonataUserBundle is enabled, it returns the timezone from the
user getTimezone() method.


Locale timezone detector
------------------------

The timezone is guessed from the current request locale. You can
configure the locale / timezone mapping in the configuration:

.. code-block:: yaml

    sonata_intl:
        timezone:
            locales:
                fr: Europe/Paris
                en_UK: Europe/London


Add a custom timezone detector
------------------------------

You can add your own timezone detector. Just create a service with the
``sonata_intl.timezone_detector`` tag with a custom alias.

.. configuration-block::

    .. code-block:: xml

       <!-- Acme/DemoBundle/Resources/config/services.xml -->
       <container xmlns="http://symfony.com/schema/dic/services"
           xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
           xsi:schemaLocation="http://symfony.com/schema/dic/services/services-1.0.xsd">
           <services>
              <service id="acme_demo.timezone_detector" class="Acme\DemoBundle\TimezoneDetector\CustomTimezoneDetector">
                 <tag name="sonata_intl.timezone_detector" alias="custom" />
             </service>
          </services>
       </container>


    .. code-block:: yaml

       # Acme/DemoBundle/Resources/config/services.yml
       services:
           acme_demo.timezone_detector:
               class: Acme\DemoBundle\TimezoneDetector\CustomTimezoneDetector
               tags:
                   - { name: sonata_intl.timezone_detector, alias: custom }

You can replace the ``custom`` tag alias by one of your choice.


Configure timezone detectors
----------------------------

By default, ``user`` then ``locale`` timezone detectors are used. You
can change this in the config:

.. code-block:: yaml

    sonata_intl:
        timezone:
            detectors:
                - user
                - locale
                - custom

**IMPORTANT** In order to guess the timezone, the detectors will be
called **in the order they are declared**.


Default timezone
----------------

If no timezone was returned by any detector, a default one will be
returned (from the ``date_default_timezone_get()`` method, configurable
in the ``php.ini`` file).

You can override this default timezone in the configuration:

.. code-block:: yaml

    sonata_intl:
        timezone:
            default: Europe/Paris
