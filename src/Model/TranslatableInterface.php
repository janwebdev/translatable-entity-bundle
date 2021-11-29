<?php

namespace Janwebdev\TranslatableEntityBundle\Model;

use Janwebdev\TranslatableEntityBundle\Model\TranslatingInterface;
use Janwebdev\TranslatableEntityBundle\Locale\LocaleInterface;

interface TranslatableInterface
{
    function setTranslation(TranslatingInterface $translation);

    function addTranslation(TranslatingInterface $translation);

    function getTranslations();

    function setLocale(LocaleInterface $locale);
}
