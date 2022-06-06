<?php

namespace Janwebdev\TranslatableEntityBundle\Model;

use Janwebdev\TranslatableEntityBundle\Model\TranslatingInterface;
use Janwebdev\TranslatableEntityBundle\Locale\LocaleInterface;

interface TranslatableInterface
{
    public function setTranslation(TranslatingInterface $translation);
    public function addTranslation(TranslatingInterface $translation);
    public function getTranslations();
    public function setLocale(LocaleInterface $locale);
}
