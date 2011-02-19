Installation
============

Make sure you have a ``Sonata`` directory, if not create it::

  mkdir src/Sonata

To begin, add the dependent bundles to the ``src/`` directory. If using
git, you can add them as submodules::

  git submodule add git@github.com:sonata-project/IntlBundle.git src/Sonata/IntlBundle

Next, be sure to enable the bundles in your application kernel:

.. code-block:: php

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

There is no configuration available, as long as the bundle is registered helper functions will
be available.