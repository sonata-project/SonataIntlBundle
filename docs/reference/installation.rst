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

Now, enable the bundle in ``bundles.php`` file::

    // config/bundles.php

    return [
        // ...
        Sonata\IntlBundle\SonataIntlBundle::class => ['all' => true],
    ];
