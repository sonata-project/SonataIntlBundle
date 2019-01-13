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

Usage
-----

Twig usage
^^^^^^^^^^

By default, if the second argument is not set then the current locale value is
retrieved by using the request instance.

The ``symbols`` option is a list of key-values pairs used by the formatter to represent
the special locale-dependent characters in a number, for example the percent sign.
For a list of available values, check the PHP_ documentation.

.. _PHP: http://php.net/manual/en/class.numberformatter.php#intl.numberformatter-constants.unumberformatsymbol

.. code-block:: jinja

    {{ 10.49|number_format_currency('EUR') }} {# => 10,49 € #}
    {{ 10.15459|number_format_decimal }} {# => 10,155 #}
    {{ 1000|number_format_scientific }} {# => 1E3 #}
    {{ 1000000|number_format_duration }} {# => 1 000 000 #}
    {{ 1000000|number_format_decimal(symbols={ 'GROUPING_SEPARATOR_SYMBOL': 'DOT' }) }} {# => 1DOT000DOT000  #}
    {{ 42|number_format_spellout }} {# => quarante-deux #}
    {{ 1.999|number_format_percent }} {# => 200 % #}
    {{ 1|number_format_ordinal }} {# => 1ᵉʳ #}
    {{ (-1.1337)|number_format_decimal({'fraction_digits': 2}, {'negative_prefix': 'MINUS'}) }} {# => MINUS1,34 #}

PHP usage
^^^^^^^^^

When defining your Admin, you can also provide extra parameters::

    // src/Admin/InvoiceAdmin.php

    namespace App\Admin;

    use Sonata\AdminBundle\Admin\AbstractAdmin;
    use Sonata\AdminBundle\Datagrid\ListMapper;
    use Sonata\AdminBundle\Show\ShowMapper;

    final class InvoiceAdmin extends AbstractAdmin
    {
        protected function configureListFields(ListMapper $listMapper)
        {
            $listMapper
                ->add('amount', 'decimal', [
                    'attributes' => ['fraction_digits' => 2],
                    'textAttributes' => ['negative_prefix' => 'MINUS'],
                ])
            ;
        }

        protected function configureShowFields(ShowMapper $showMapper)
        {
            $showMapper
                ->add('price', 'currency', [
                    'currency' => 'EUR',
                    'locale' => 'fr',
                ])
            ;
        }
    }
