Datetime Helper
================

The DateTime helper provides functions to format:
 - date
 - time
 - datetime


Twig usage
==========

By default, if the third argument is not set then the current locale value is
retrieved by using the session instance.

.. code-block:: twig

    {{ date_time_object | format_date }} => '1 août 2011'
    {{ date_time_object | format_time }} => '19:55:26'
    {{ date_time_object | format_datetime }} => '1 août 2011 19:55:26'

The second argument can be used to use a specific pattern :

.. code-block:: twig

    {{ date_time_object | format_date('dd MMM Y G') }} => '01 août 2011 ap. J.-C.'

More information about patterns can be found here: http://userguide.icu-project.org/formatparse/datetime