Configuration
=============

To display dates, this bundle uses timezone detectors to get the
current timezone.

User timezone detector
----------------------

If the SonataUserBundle is enabled, it returns the timezone from the
``Sonata\UserBundle\Modle\User::getTimezone()`` method.


Locale timezone detector
------------------------

The timezone is guessed from the current request locale. You can
configure the locale / timezone mapping in the configuration:

.. code-block:: yaml

    sonata_intl:
        timezone:
            locales:
                fr:    Europe/Paris
                en_UK: Europe/London


Configure timezone detectors
----------------------------

By default, ``user`` then ``locale`` timezone detectors are used. You
can change this in the config:

.. code-block:: yaml

    sonata_intl:
        timezone:
            detectors:
                - sonata.intl.timezone_detector.user
                - sonata.intl.timezone_detector.locale

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
