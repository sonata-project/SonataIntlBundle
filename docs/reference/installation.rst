.. index::
    single: Installation

Installation
============

Prerequisites
-------------

This bundle requires the ``php-intl`` extension.

The easiest way to install ``SonataIntlBundle`` is to require it with Composer:

.. code-block:: bash

    $ php composer.phar require sonata-project/intl-bundle

Alternatively, you could add a dependency into your ``composer.json`` file directly.

Now, enable the bundle in the kernel:

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
