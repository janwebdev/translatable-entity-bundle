<?php

namespace Janwebdev\TranslatableEntityBundle\Locale;

interface LocaleInterface
{
    public function setLocale(string $locale): void;
    
    public function getLocale(): string;
    
    public function getDefaultLocale(): string;
}
