Datetime Helper
===============

The DateTime helper provides functions to format:

 - a date :  ``format_date``
 - time   : ``format_time``
 - date and time : ``format_datetime``

Usage
-----

Twig usage
^^^^^^^^^^

You can format a compatible date with 4 methods, a date can be:

 - a ``DateTime`` object
 - a timestamp : ``375930000``
 - a date string : ``'1981-11-30'``

.. code-block:: html+twig

    {{ date_time_object | format_date }} => '1 févr. 2011'
    {{ date_time_object | format_time }} => '19:55:26'
    {{ date_time_object | format_datetime }} => '1 févr. 2011 19:55:26'

By default the helper methods use the current user's locale to display
information. Of course this behavior can be controlled from within the template
by providing extra parameters :

* pattern : the pattern to use to render the date
* the locale
* the timezone to use if date is not a ``DateTime`` instance
* (``format_date`` and ``format_datetime`` only) the date type to use if no pattern
  were provided: the given value must be one of ``\IntlDateFormatter::{SHORT, MEDIUM, LONG, FULL}``
  or ``null`` (if ``null``, defaults to ``\IntlDateFormatter::MEDIUM``)
* (``format_time`` and ``format_datetime`` only) the time type to use if no pattern
  were provided: the given value must be one of ``\IntlDateFormatter::{SHORT, MEDIUM, LONG, FULL}``
  or ``null`` (if ``null``, defaults to ``\IntlDateFormatter::MEDIUM``)

.. code-block:: html+twig

    {{ date_time_object | format_date(null, 'fr', 'Europe/Paris', constant('IntlDateFormatter::LONG')) }} => '1 février 2011'
    {{ date_time_object | format_time(null, 'fr', 'Europe/Paris', constant('IntlDateFormatter::SHORT')) }} => '19:55'
    {{ date_time_object | format_datetime(null, 'fr', 'Europe/Paris',
        constant('IntlDateFormatter::LONG'), constant('IntlDateFormatter::SHORT')) }} => '1 février 2011 19:55'
    {{ date_time_object | format_[date|time|datetime]('dd MMM y G', 'fr', 'Europe/Paris') }} => '01 février 2011 ap. J.-C.'

.. note::

    More information about patterns can be found here_:

PHP usage
^^^^^^^^^

When defining your Admin, you can also provide extra parameters::

    // src/Admin/PostAdmin.php

    namespace App\Admin;

    use Sonata\AdminBundle\Admin\AbstractAdmin;
    use Sonata\AdminBundle\Datagrid\ListMapper;

    final class PostAdmin extends AbstractAdmin
    {
        protected function configureListFields(ListMapper $listMapper)
        {
            $listMapper
                ->add('createdAt', 'date', [
                    'pattern' => 'dd MMM y G',
                    'locale' => 'fr',
                    'timezone' => 'Europe/Paris',
                ])
            ;
        }
    }

.. _here: http://userguide.icu-project.org/formatparse/datetime
