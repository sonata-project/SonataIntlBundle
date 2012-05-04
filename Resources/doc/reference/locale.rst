Locale Helper
=============

The locale helper provides functions to display:
 - country name from the ISO code
 - language name from the ISO code
 - locale name from the ISO code


Twig usage
----------

By default, if the second argument is not set then the current locale value is
retrieved by using the request instance.


.. code-block:: jinja

    {{ 'FR' | country }} {# => France (if the current locale in session is 'fr') #}
    {{ 'FR' | country('de') }} {# => Frankreich (force the locale) #}

    {{ 'fr' | language }} => {# français (if the current locale in session is 'fr') #}
    {{ 'fr' | language('en') }} {# => French (force the locale) #}

    {{ 'fr' | locale }} {# => français (if the current locale in session is 'fr') #}
    {{ 'fr' | locale('en') }} {# => French (force the locale) #}

