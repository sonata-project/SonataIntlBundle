Datetime Helper
================

The DateTime helper provides functions to format :
 - date
 - time
 - datetime


Twig usage
==========

By default, if the third argument is not set then the current locale value is
retrieved by using the session instance.

.. code-block:: twig

    {% format_date date_time_object %} => '30 nov. 1981'
    {% format_time date_time_object %} => '02:00:00'
    {% format_datetime date_time_object %} => '30 nov. 1981'

The second argument can be used to use a specific pattern :

.. code-block:: twig

    {% format_date date_time_object, 'dd MMM Y G' %} => '30 nov. 1981 ap. J.-C.'

more information about patterns can be found here : http://userguide.icu-project.org/formatparse/datetime