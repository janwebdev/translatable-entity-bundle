<?php

namespace Janwebdev\TranslatableEntityBundle\Locale;

class Locale implements LocaleInterface
{
    private string $locale;
    private string $defaultLocale;

    public function __construct($defaultLocale)
    {
        $this->locale        = $defaultLocale;
        $this->defaultLocale = $defaultLocale;
    }

    public function setLocale($locale): void
    {
        $this->locale = $locale;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getDefaultLocale(): string
    {
        return $this->defaultLocale;
    }
}
