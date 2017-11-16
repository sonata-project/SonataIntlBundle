Create a custom timezone detector
=================================

You can create and add your own timezone detector.

Create the detector class
-------------------------

Todo:
  - add example class called ``MyCustomTimezoneDetector``

Add the Service
---------------

Create a service with the ``sonata_intl.timezone_detector`` tag with a custom alias.

.. configuration-block::

    .. code-block:: xml

        <!-- src/AppBundle/Resources/config/services.xml -->

        <service id="app.my_custom_timezone_detector" class="AppBundle\TimezoneDetector\MyCustomTimezoneDetector">
            <tag name="sonata_intl.timezone_detector" />
        </service>

    .. code-block:: yaml

        # src/AppBundle/Resources/config/services.yml

        services:
            app.my_custom_timezone_detector:
                class: AppBundle\TimezoneDetector\MyCustomTimezoneDetector
                tags:
                    - { name: sonata_intl.timezone_detector }

Add the detector to the Configuration
-------------------------------------

You can now use this class by configuring the ``detector`` section:

.. configuration-block::

    .. code-block:: yaml

        sonata_intl:
            timezone:
                detectors:
                    - app.my_custom_timezone_detector
                    - sonata.intl.timezone_detector.user
                    - sonata.intl.timezone_detector.locale

**IMPORTANT** In order to guess the timezone, the detectors will be
called **in the order they are declared**.