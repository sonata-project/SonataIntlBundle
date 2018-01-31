.. index::
    single: Installation

Installation
============

Prerequisites
-------------

This bundle requires the ``php-intl`` extension.

The easiest way to install ``SonataIntlBundle`` is to require it with Composer:

.. code-block:: bash

    composer require sonata-project/intl-bundle

Alternatively, you could add a dependency into your ``composer.json`` file directly.

Now, enable the bundle in ``bundles.php`` file:

.. code-block:: php

    <?php

    // config/bundles.php

    return [
        //...
        Sonata\IntlBundle\SonataIntlBundle => ['all' => true],
    ];

.. note::
    If you are not using Symfony Flex, you should enable bundles in your
    ``AppKernel.php``.

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
