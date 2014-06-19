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

If you have trouble using twig extension like "Only the locale "en" is supported." even after having install the php intl extension and restart apache, you can add the symfony locales in composer.json ::

  
	"symfony/locale": "2.3.*"
		
Then, run php composer.phar update.
