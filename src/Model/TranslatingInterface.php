<?php

namespace Janwebdev\TranslatableEntityBundle\Model;

interface TranslatingInterface
{
    public function setLocale(string $locale): void;
    
    public function getLocale(): string;
    
    public function setTranslatable(TranslatableInterface $translatable): void;
}
