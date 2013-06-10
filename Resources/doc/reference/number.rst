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
----------

By default, if the second argument is not set then the current locale value is
retrieved by using the request instance.


.. code-block:: jinja

    {{ 10.49|number_format_currency('EUR') }} {# => 10,49 € #}
    {{ 10.15459|number_format_decimal }} {# => 10,155 #}
    {{ 1000|number_format_scientific }} {# => 1E3 #}
    {{ 1000000|number_format_duration }} {# => 1 000 000 #}
    {{ 42|number_format_spellout }} {# => quarante-deux #}
    {{ 1.999|number_format_percent }} {# => 200 % #}
    {{ 1|number_format_ordinal }} {# => 1ᵉʳ #}
    {{ (-1.1337)|number_format_decimal({'fraction_digits': 2}, {'negative_prefix': 'MINUS'}) }} {# => MINUS1,34 #}


PHP usage
---------

When defining your admin list / view, you can also provide extra parameters, for example :

.. code-block:: php

    $list->add('amount', 'decimal', array(
        'attributes' => array('fraction_digits' => 2),
        'textAttributes' => array('negative_prefix' => 'MINUS'),
    ))

    $show->add('price', 'currency', array(
        'currency' => 'EUR',
        'locale' => 'fr',
    ))
