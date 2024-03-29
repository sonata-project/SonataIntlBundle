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

.. code-block:: yaml

    # config/services.yaml

    services:
        app.my_custom_timezone_detector:
            class: App\TimezoneDetector\MyCustomTimezoneDetector
            tags:
                - { name: sonata_intl.timezone_detector }

Add the detector to the Configuration
-------------------------------------

You can now use this class by configuring the ``detector`` section:

.. code-block:: yaml

    # config/packages/sonata_intl.yaml

    sonata_intl:
        timezone:
            detectors:
                - app.my_custom_timezone_detector
                - sonata.intl.timezone_detector.user
                - sonata.intl.timezone_detector.locale_aware

.. important::

    In order to guess the timezone, the detectors will be called **in the order they are declared**.
