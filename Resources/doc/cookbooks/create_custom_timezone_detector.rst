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
              <service id="acme_demo.timezone_detector" class="Acme\DemoBundle\TimezoneDetector\CustomTimezoneDetector" />
          </services>
       </container>


    .. code-block:: yaml

       # Acme/DemoBundle/Resources/config/services.yml
       services:
           acme_demo.timezone_detector:
               class: Acme\DemoBundle\TimezoneDetector\CustomTimezoneDetector


You can now use this class by configuring the ``detector`` section:

.. code-block:: yaml

    sonata_intl:
        timezone:
            detectors:
                - acme_demo.timezone_detector
                - sonata.intl.timezone_detector.user
                - sonata.intl.timezone_detector.locale

**IMPORTANT** In order to guess the timezone, the detectors will be
called **in the order they are declared**.