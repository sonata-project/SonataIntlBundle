Number Helper
=============

The number helper provides functions to format :
 - currency
 - decimal
 - scientific
 - duration
 - spellout
 - percent
 - ordinal


Twig usage
==========

By default, if the second argument is not set then the current locale value is
retrieved by using the session instance.


.. code-block:: twig

    {% currency 10.49, 'EUR' %} => 10,49 €
    {% decimal 10.15459  %} => 10,155
    {% scientific 1000 %} => 1E3
    {% duration 1000000  %} => 1 000 000
    {% spellout 42 %} => quarante-deux
    {% percent 1.999  %} => 200 %
    {% ordinal 1 %} => 1ᵉʳ
