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

    {% country 'FR' %} => France
    {% country 'FR', 'en'  %} => France (force the locale)

    {% language 'fr' %} => français (if the current locale in session is 'fr')
    {% language 'FR', 'en'  %} => french (force the locale)

    {% locale 'fr' %} => français (if the current locale in session is 'fr')
    {% locale 'FR', 'en'  %} => french (force the locale)

