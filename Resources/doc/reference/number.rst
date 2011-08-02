Number Helper
=============

The number helper provides functions to format:
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

    {{ number_format_currency(10.49, 'EUR') }} => 10,49 €
    {{ number_format_decimal(10.15459) }} => 10,155
    {{ number_format_scientific(1000) }} => 1E3
    {{ number_format_duration(1000000) }} => 1 000 000
    {{ number_format_spellout(42) }} => quarante-deux
    {{ number_format_percent(1.999 )}} => 200 %
    {{ number_format_ordinal(1) }} => 1ᵉʳ
