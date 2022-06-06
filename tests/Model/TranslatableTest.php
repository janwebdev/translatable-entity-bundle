<?php

namespace Janwebdev\TranslatableEntityBundle\Tests\Model;

use Janwebdev\TranslatableEntityBundle\Model\TranslatingInterface;
use PHPUnit\Framework\TestCase;
use Janwebdev\TranslatableEntityBundle\Tests\TranslationEn;
use Janwebdev\TranslatableEntityBundle\Tests\TranslationIt;
use Janwebdev\TranslatableEntityBundle\Tests\TranslationDe;
use Janwebdev\TranslatableEntityBundle\Locale\LocaleInterface;
use Janwebdev\TranslatableEntityBundle\Tests\Translatable;

class TranslatableTest extends TestCase
{
    protected $translationStubEn;
    protected $translationStubIt;
    protected $translationStubDe;
    protected $locale;

    public function setUp(): void
    {
        $this->translationStubEn = $this->getMockBuilder(TranslationEn::class)->disableOriginalConstructor()->getMock();
        $this->translationStubIt  = $this->getMockBuilder(TranslationIt::class)->disableOriginalConstructor()->getMock();
        $this->translationStubDe  = $this->getMockBuilder(TranslationDe::class)->disableOriginalConstructor()->getMock();
        $this->locale = $this->getMockBuilder(LocaleInterface::class)->disableOriginalConstructor()->getMock();
    }
    
    public function getTranslationProvider(): array
    {
        return [
          [
          	[
          		'it' => 'translationStubIt',
	            'en' => 'translationStubEn'
            ],
	          'en',
	          'en',
	          'translationStubEn'
          ], //testGetTranslationLocaleEqualDefault
          [
          	[
          		'en' => 'translationStubEn',
	            'it' => 'translationStubIt'
            ],
	          'en',
	          'it',
	          'translationStubIt'
          ], //testGetTranslationLocaleEqualIt
          [
          	[
          		'en' => 'translationStubEn'
            ],
	          'en',
	          'it',
	          'translationStubEn'
          ], //testGetTranslationDefaultLocaleLessLocaleSettedReturnDefault
        ];
    }
    
    /**
     * @dataProvider getTranslationProvider
     */
    public function testGetTranslation($translations, $defaultLocale, $locale, $translationExpected): void
    {
        $translatable = new Translatable();
        $translatable->setLocale($this->locale);
        
        foreach ($translations as $language => $translation) {
            $this->$translation->expects($this->exactly(2))->method('getLocale')->willReturn($language);
            $translatable->addTranslation($this->$translation);
        }
        
        $this->locale->expects($this->exactly(1))->method('getDefaultLocale')->willReturn($defaultLocale);
        $this->locale->expects($this->exactly(1))->method('getLocale')->will($this->returnValue($locale));
               
        $result = $translatable->getTranslation();
        $this->assertEquals($this->$translationExpected, $result);
    }

	public function testHandleNotFoundThrowsException(): void
	{
	    $this->expectException(\RuntimeException::class);
	    $translatable = new Translatable();
        $translatable->setLocale($this->locale);
        $this->translationStubDe->expects($this->exactly(2))->method('getLocale')->willReturn('de');
        $translatable->addTranslation($this->translationStubDe);
        
        $this->locale->expects($this->exactly(1))->method('getDefaultLocale')->willReturn('en');
        $this->locale->expects($this->exactly(1))->method('getLocale')->willReturn('it');
        
        $translatable->getTranslation();
    }

    public function testHandleNotFoundReturnsNull(): void
    {
        $translatable = new Translatable();
        $translatable->handleNotFound = $translatable::HANDLE_NOT_FOUND_NULL;
        $translatable->setLocale($this->locale);
        $this->translationStubDe->expects($this->exactly(2))->method('getLocale')->willReturn('de');
        $translatable->addTranslation($this->translationStubDe);

        $this->locale->expects($this->exactly(1))->method('getDefaultLocale')->willReturn('en');
        $this->locale->expects($this->exactly(1))->method('getLocale')->willReturn('it');

        $result = $translatable->getTranslation();
        $this->assertNull($result);
    }

    public function testHandleNotFoundReturnsEmptyObject(): void
    {
        $translatable = new Translatable();
        $translatable->handleNotFound = $translatable::HANDLE_NOT_FOUND_EMTPY_OBJECT;
        $translatable->setLocale($this->locale);
        $this->translationStubDe->expects($this->exactly(2))->method('getLocale')->willReturn('de');
        $translatable->addTranslation($this->translationStubDe);

        $this->locale->expects($this->exactly(1))->method('getDefaultLocale')->willReturn('en');
        $this->locale->expects($this->exactly(1))->method('getLocale')->willReturn('it');

        $result = $translatable->getTranslation();
        $this->assertInstanceOf(TranslatingInterface::class, $result);
    }
}
