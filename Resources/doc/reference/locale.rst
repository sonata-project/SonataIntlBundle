Locale Helper
=============

The locale helper provides functions to display:
 - country name from the ISO code
 - language name from the ISO code
 - locale name from the ISO code


Twig usage
==========

By default, if the second argument is not set then the current locale value is
retrieved by using the session instance.


.. code-block:: twig

    {{ country('FR') }} => France (if the current locale in session is 'fr')
    {{ country('FR', 'de') }} => Frankreich (force the locale)
    
    {{ language('fr') }} => français (if the current locale in session is 'fr')
    {{ language('fr', 'en') }} => French (force the locale)

    {{ locale('fr') }} => français (if the current locale in session is 'fr')
    {{ locale('fr', 'en') }} => French (force the locale)

