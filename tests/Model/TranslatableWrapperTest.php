<?php

namespace Janwebdev\TranslatableEntityBundle\Tests\Model;

use Janwebdev\TranslatableEntityBundle\Tests\TranslatableWrapper;
use Janwebdev\TranslatableEntityBundle\Tests\TranslationEn;
use PHPUnit\Framework\TestCase;
use Janwebdev\TranslatableEntityBundle\Locale\LocaleInterface;

class TranslatableWrapperTest extends TestCase
{
	protected $translationStubEn;
	protected $locale;
	protected $translatable;

	public function setUp(): void
    {
        $this->translationStubEn = new TranslationEn();
        $this->locale = $this->getMockBuilder(LocaleInterface::class)->disableOriginalConstructor()->getMock();

        $this->translatable = new TranslatableWrapper();
        $this->translatable->setLocale($this->locale);
        $this->translatable->addTranslation($this->translationStubEn);
    }

    public function testMagicCallOk(): void
    {
        $this->locale->expects($this->exactly(1))->method('getDefaultLocale')->willReturn('en');
        $this->locale->expects($this->exactly(1))->method('getLocale')->willReturn('en');
        $result = $this->translatable->getName();
        $this->assertEquals('name', $result);
    }

	public function testMagicCallKo(): void
	{
	    $this->expectException(\RuntimeException::class);
	    $this->locale->expects($this->exactly(1))->method('getDefaultLocale')->willReturn('en');
        $this->locale->expects($this->exactly(1))->method('getLocale')->willReturn('en');
        
        $result = $this->translatable->getSurname();
    }
}
