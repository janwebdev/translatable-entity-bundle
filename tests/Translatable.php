<?php

namespace Janwebdev\TranslatableEntityBundle\Tests;

use Janwebdev\TranslatableEntityBundle\Model\Translatable as BaseTranslatable;

class Translatable extends BaseTranslatable
{
    public const HANDLE_NOT_FOUND_EXCEPTION = 'exception';
	public const HANDLE_NOT_FOUND_NULL = 'null';
	public const HANDLE_NOT_FOUND_EMTPY_OBJECT = 'emptyObject';

    protected $translations = [];
    public string $handleNotFound = self::HANDLE_NOT_FOUND_EXCEPTION;

    public function getTranslations(): array
    {
        return $this->translations;
    }

    protected function handleTranslationNotFound()
    {
        $strategy = 'handle' .ucfirst($this->handleNotFound);
        $this->$strategy();
    }

    private function handleException()
    {
        parent::handleTranslationNotFound();
    }

    private function handleNull()
    {
        $this->translation = null;
    }

    private function handleEmptyObject()
    {
        $this->translation = new TranslationEn();
    }
}
