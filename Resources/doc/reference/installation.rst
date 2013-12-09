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

