<?php

namespace Janwebdev\TranslatableEntityBundle\Tests;

class TranslationEn extends AbstractTranslation
{
    public function getName() 
    {
        return "name";
    }
    
    public function getLocale()
    {
        return "en";
    }
    
    private function getSurname() {}
}
