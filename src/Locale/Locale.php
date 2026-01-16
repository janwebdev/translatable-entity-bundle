<?php

namespace Janwebdev\TranslatableEntityBundle\Locale;

class Locale implements LocaleInterface
{
    private string $locale;

    public function __construct(
        private readonly string $defaultLocale
    ) {
        $this->locale = $defaultLocale;
    }

    public function setLocale(string $locale): void
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
