<?php

namespace Janwebdev\TranslatableEntityBundle\Tests\Locale;

use Janwebdev\TranslatableEntityBundle\Locale\Locale;
use PHPUnit\Framework\TestCase;

class LocaleTest extends TestCase
{
    public function testLocale(): void
    {
        $locale = new Locale('en');
        $locale->setLocale('it');
        
        $this->assertEquals('it', $locale->getLocale());
    }
    
    public function testLocaleDefault(): void
    {
        $locale = new Locale('en');
        
        $this->assertEquals('en', $locale->getDefaultLocale());
    }
}
