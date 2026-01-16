<?php

namespace Janwebdev\TranslatableEntityBundle\Model;

use Janwebdev\TranslatableEntityBundle\Locale\LocaleInterface;
use Doctrine\Common\Collections\Collection;

interface TranslatableInterface
{
    public function setTranslation(TranslatingInterface $translation): void;
    
    public function addTranslation(TranslatingInterface $translation): void;
    
    /**
     * @return Collection<int|string, TranslatingInterface>|array<string, TranslatingInterface>
     */
    public function getTranslations(): Collection|array;
    
    public function setLocale(LocaleInterface $locale): void;
}
