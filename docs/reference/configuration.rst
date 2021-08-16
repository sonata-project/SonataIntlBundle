Configuration
=============

To display dates, this bundle uses timezone detectors to get the
current timezone.

Timezone detectors
------------------

User timezone detector
^^^^^^^^^^^^^^^^^^^^^^

.. versionadded:: 2.7

    If the model class for the authenticated user implements ``Sonata\IntlBundle\Timezone\TimezoneAwareInterface``,
    it returns the timezone from its ``getTimezone()`` method.
    For convenience, the ``Sonata\IntlBundle\Timezone\TimezoneAwareTrait`` is available,
    which provides a basic implementation.

**DEPRECATED**
Relying on ``Sonata\UserBundle\Model\User`` is deprecated since 2.x in favor of
explicit implementation of ``Sonata\IntlBundle\Timezone\TimezoneAwareInterface``.

If the SonataUserBundle_ is enabled, it returns the timezone from the
``Sonata\UserBundle\Model\User::getTimezone()`` method.

Locale timezone detector
^^^^^^^^^^^^^^^^^^^^^^^^

The timezone is guessed from the current request locale. You can
configure the locale / timezone mapping in the configuration:

.. configuration-block::

    .. code-block:: yaml

        # config/packages/sonata_intl.yaml

        sonata_intl:
            timezone:
                locales:
                    fr:    Europe/Paris
                    en_UK: Europe/London

Configure timezone detectors
^^^^^^^^^^^^^^^^^^^^^^^^^^^^

By default, ``user`` then ``locale`` timezone detectors are used. You
can change the order in the configuration:

.. configuration-block::

    .. code-block:: yaml

        # config/packages/sonata_intl.yaml

        sonata_intl:
            timezone:
                detectors:
                    - sonata.intl.timezone_detector.user
                    - sonata.intl.timezone_detector.locale

**IMPORTANT** In order to guess the timezone, the detectors will be
called **in the order they are declared**.

Default timezone
^^^^^^^^^^^^^^^^

If no timezone was returned by any detector, a default one will be
returned (from the ``date_default_timezone_get()`` method, configurable
in the ``php.ini`` file).

You can override this default timezone in the configuration:

.. configuration-block::

    .. code-block:: yaml

        # config/packages/sonata_intl.yaml

        sonata_intl:
            timezone:
                default: Europe/Paris

.. _SonataUserBundle: https://docs.sonata-project.org/projects/SonataUserBundle/en/4.x/reference/installation/#enable-the-bundle
