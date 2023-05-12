Locale Helper
=============

The locale helper provides functions to display:
 - country name from the ISO code
 - language name from the ISO code
 - locale name from the ISO code

Detection
---------

The SonataIntlBundle provides a service to automatically detect the user's locale.
``sonata.intl.locale_detector`` will be request-based.

You'll need to handle the locale setting however.

Twig usage
----------

By default, if the second argument is not set then the current locale value is
retrieved by using the request instance.


.. code-block:: html+twig

    {{ 'FR' | country }} {# => France (if the current locale in session is 'fr') #}
    {{ 'FR' | country('de') }} {# => Frankreich (force the locale) #}

    {{ 'fr' | language }} => {# français (if the current locale in session is 'fr') #}
    {{ 'fr' | language('en') }} {# => French (force the locale) #}

    {{ 'fr' | locale }} {# => français (if the current locale in session is 'fr') #}
    {{ 'fr' | locale('en') }} {# => French (force the locale) #}
