<?php

namespace Janwebdev\TranslatableEntityBundle\Tests\Service;

use Janwebdev\TranslatableEntityBundle\Tests\Translatable;

class TranslatableTest extends \PHPUnit_Framework_TestCase
{
    protected $translationStubEn;
    protected $translationStubIt;
    
    public function setUp()
    {
        $this->translationStubEn  = $this->getMockBuilder('Janwebdev\TranslatableEntityBundle\Tests\TranslationEn')->disableOriginalConstructor()->getMock();
        $this->translationStubIt  = $this->getMockBuilder('Janwebdev\TranslatableEntityBundle\Tests\TranslationIt')->disableOriginalConstructor()->getMock();
        $this->translationStubDe  = $this->getMockBuilder('Janwebdev\TranslatableEntityBundle\Tests\TranslationDe')->disableOriginalConstructor()->getMock();
        $this->locale             = $this->getMockBuilder('Janwebdev\TranslatableEntityBundle\Locale\LocaleInterface')->disableOriginalConstructor()->getMock();
    }
    
    /**
     *
     * tranlsations, locale, defaultLocale, tranlsationExpected
     */
    public function getTranslationProvider()
    {
        return array(
          array(array('it' => 'translationStubIt', 'en' => 'translationStubEn'), 'en', 'en', 'translationStubEn'), //testGetTranslationLocaleEqualDefault
          array(array('en' => 'translationStubEn', 'it' => 'translationStubIt'), 'en', 'it', 'translationStubIt'), //testGetTranslationLocaleEqualIt
          array(array('en' => 'translationStubEn'), 'en', 'it', 'translationStubEn'), //testGetTranslationDefaultLocaleLessLocaleSettedReturnDefault
        );   
    }
    
    /**
     * @dataProvider getTranslationProvider
     */
    public function testGetTranslation($translations, $defaultLocale, $locale, $translationExpected)
    {
        $translatable = new Translatable();
        $translatable->setLocale($this->locale);
        
        foreach ($translations as $language => $translation) {
            $this->$translation->expects($this->exactly(2))->method('getLocale')->will($this->returnValue($language));
            $translatable->addTranslation($this->$translation);
        }
        
        $this->locale->expects($this->exactly(1))->method('getDefaultLocale')->will($this->returnValue($defaultLocale));
        $this->locale->expects($this->exactly(1))->method('getLocale')->will($this->returnValue($locale));
               
        $result = $translatable->getTranslation();
        $this->assertEquals($this->$translationExpected, $result);
    }
    
    /**
     * @expectedException RuntimeException
     */
    public function testHandleNotFoundThrowsException()
    {
        $translatable = new Translatable(array($this->translationStubDe));
        $translatable->setLocale($this->locale);
        $this->translationStubDe->expects($this->exactly(2))->method('getLocale')->will($this->returnValue('de'));
        $translatable->addTranslation($this->translationStubDe);
        
        $this->locale->expects($this->exactly(1))->method('getDefaultLocale')->will($this->returnValue('en'));
        $this->locale->expects($this->exactly(1))->method('getLocale')->will($this->returnValue('it'));
        
        $translatable->getTranslation();
    }

    public function testHandleNotFoundReturnsNull()
    {
        $translatable = new Translatable(array($this->translationStubDe));
        $translatable->handleNotFound = $translatable::HANDLE_NOT_FOUND_NULL;
        $translatable->setLocale($this->locale);
        $this->translationStubDe->expects($this->exactly(2))->method('getLocale')->will($this->returnValue('de'));
        $translatable->addTranslation($this->translationStubDe);

        $this->locale->expects($this->exactly(1))->method('getDefaultLocale')->will($this->returnValue('en'));
        $this->locale->expects($this->exactly(1))->method('getLocale')->will($this->returnValue('it'));

        $result = $translatable->getTranslation();
        $this->assertNull($result);
    }

    public function testHandleNotFoundReturnsEmptyObject()
    {
        $translatable = new Translatable(array($this->translationStubDe));
        $translatable->handleNotFound = $translatable::HANDLE_NOT_FOUND_EMTPY_OBJECT;
        $translatable->setLocale($this->locale);
        $this->translationStubDe->expects($this->exactly(2))->method('getLocale')->will($this->returnValue('de'));
        $translatable->addTranslation($this->translationStubDe);

        $this->locale->expects($this->exactly(1))->method('getDefaultLocale')->will($this->returnValue('en'));
        $this->locale->expects($this->exactly(1))->method('getLocale')->will($this->returnValue('it'));

        $result = $translatable->getTranslation();
        $this->assertInstanceOf('Janwebdev\TranslatableEntityBundle\Tests\Translatable', $result);
        $this->assertNull($result->getDummyValue());
    }
}
