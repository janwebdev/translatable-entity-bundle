<?php

namespace Janwebdev\TranslatableEntityBundle\Model;

use Janwebdev\TranslatableEntityBundle\Locale\LocaleInterface;

abstract class Translatable implements TranslatableInterface
{
    /** @var array<string, TranslatingInterface> */
    protected array $translations = [];

    protected ?TranslatingInterface $translation = null;

    protected ?LocaleInterface $locale = null;

    public function setLocale(LocaleInterface $locale): void
    {
        $this->locale = $locale;
    }

    public function setTranslation(TranslatingInterface $translation): void
    {
        $this->translation = $translation;
    }

    public function addTranslation(TranslatingInterface $translation): void
    {
        $this->translations[$translation->getLocale()] = $translation;
    }

    protected function handleTranslationNotFound(): never
    {
        throw new \RuntimeException('Translation not found');
    }

    /**
     * if you need a translation even in a translation in current language was not found, return true
     */
    protected function acceptFirstTranslationAsDefault(): bool
    {
        return false;
    }

    /**
     * if you don't want that only translation in locale will be returned, return false
     */
    protected function acceptDefaultLocaleTranslationAsDefault(): bool
    {
        return true;
    }

    /**
     * Get current translation based on locale
     * 
     * This method implements a fallback mechanism:
     * 1. Try to find translation for current locale
     * 2. If not found, try default locale (if enabled)
     * 3. If not found, try first available translation (if enabled)
     * 4. If still not found, handle translation not found
     * 
     * @return TranslatingInterface|null
     */
    public function getTranslation(): ?TranslatingInterface
    {
        // Return cached translation if already resolved
        if ($this->translation !== null) {
            return $this->translation;
        }

        $translations = $this->getTranslations();
        $locale = $this->locale->getLocale();
        $defaultLocale = $this->locale->getDefaultLocale();
        
        $defaultTranslation = null;
        $firstTranslation = null;

        // Single pass through translations for better performance
        foreach ($translations as $translation) {
            $translationLocale = $translation->getLocale();
            
            // Store first translation if we accept it as fallback
            if ($firstTranslation === null && $this->acceptFirstTranslationAsDefault()) {
                $firstTranslation = $translation;
            }

            // Store default locale translation if we accept it as fallback
            if ($translationLocale === $defaultLocale && $this->acceptDefaultLocaleTranslationAsDefault()) {
                $defaultTranslation = $translation;
            }

            // Found exact match - use it immediately
            if ($translationLocale === $locale) {
                $this->setTranslation($translation);
                return $this->translation;
            }
        }

        // Use fallback logic: default locale > first translation
        $fallbackTranslation = $defaultTranslation ?? $firstTranslation;
        
        if ($fallbackTranslation !== null) {
            $this->setTranslation($fallbackTranslation);
            return $this->translation;
        }

        // No translation found - handle error
        $this->handleTranslationNotFound();
    }
}
