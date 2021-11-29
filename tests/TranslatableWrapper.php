<?php

namespace Janwebdev\TranslatableEntityBundle\Tests;

use Janwebdev\TranslatableEntityBundle\Model\TranslatableWrapper as BaseTranslatable;

class TranslatableWrapper extends BaseTranslatable
{    
    protected $translations;
        
    public function getTranslations()
    {
        return $this->translations;
    }      
}
