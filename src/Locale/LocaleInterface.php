<?php

namespace Janwebdev\TranslatableEntityBundle\Locale;

interface LocaleInterface
{
    public function setLocale($locale): void;
    public function getLocale(): string;
    public function getDefaultLocale(): string;
}
