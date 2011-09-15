Datetime Helper
================

The DateTime helper provides functions to format:

 - date
 - time
 - datetime


Twig usage
----------

You can format a compatible date with 4 methods, a date can be:

 - a ``DateTime`` object
 - a timestamp a date string (``375930000``)
 - a string date ``1981-11-30``


.. code-block:: twig

    {{ date_time_object | format_date }} => '1 août 2011'
    {{ date_time_object | format_time }} => '19:55:26'
    {{ date_time_object | format_datetime }} => '1 août 2011 19:55:26'
    {{ date_time_object | format('dd MMM Y G') }} => '01 août 2011 ap. J.-C.'

By default the helpers methods use the current user's locale to display information. Of course this behavior can
be controller from within the template by providing extra parameters.

.. code-block:: twig

    {{ date_time_object | format_date('fr', 'Europe/Paris') }} => '1 août 2011'
    {{ date_time_object | format_time('fr', 'Europe/Paris') }} => '19:55:26'
    {{ date_time_object | format_datetime('fr', 'Europe/Paris') }} => '1 août 2011 19:55:26'
    {{ date_time_object | format('dd MMM Y G', 'fr', 'Europe/Paris') }} => '01 août 2011 ap. J.-C.'


.. note::

    More information about patterns can be found here: http://userguide.icu-project.org/formatparse/datetime