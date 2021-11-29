<?php

namespace Janwebdev\TranslatableEntityBundle\Locale;

interface LocaleInterface
{
    function setLocale($locale);

    function getLocale();

    function getDefaultLocale();
}
