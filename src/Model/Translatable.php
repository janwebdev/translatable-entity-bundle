<?php

namespace Janwebdev\TranslatableEntityBundle\Model;

use Janwebdev\TranslatableEntityBundle\Locale\LocaleInterface;

abstract class Translatable implements TranslatableInterface
{
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

    public function addTranslation(TranslatingInterface $translation)
    {
        $this->translations[$translation->getLocale()] = $translation;
    }

    protected function handleTranslationNotFound()
    {
        throw new \RuntimeException('Translation not found');
    }

    /**
     * if you need a transaltion even in a translation in current language was not found, return true
     */
    protected function acceptFirstTransaltionAsDefault(): bool
    {
        return false;
    }

    /**
     * if you don't want that only translation in locale will be returned, return false
     */
    protected function acceptDefaultLocaleTransaltionAsDefault(): bool
    {
        return true;
    }

    /**
     * get current translation based on locale
     * @return TranslatingInterface $translation|null
     */
    public function getTranslation()
    {
        if (!is_null($this->translation)) {
            return $this->translation;
        }

        $translations   = $this->getTranslations();
        $defaultLocale  = $this->locale->getDefaultLocale();
        $locale         = $this->locale->getLocale();

        foreach ($translations as $translation) {
            if ($this->acceptFirstTransaltionAsDefault()) {
                $defaultTranslation = $translation;
            }

            $translationLocale = $translation->getLocale();

            if ($translationLocale === $defaultLocale && $this->acceptDefaultLocaleTransaltionAsDefault()) {
                $defaultTranslation = $translation;
            }

            if ($translationLocale === $locale) {
                $this->setTranslation($translation);
                break;
            }
        }

        if (is_null($this->translation) && isset($defaultTranslation)) {
            $this->setTranslation($defaultTranslation);
        }

        if (is_null($this->translation)) {
            $this->handleTranslationNotFound();
        }

        return $this->translation;
    }
}
