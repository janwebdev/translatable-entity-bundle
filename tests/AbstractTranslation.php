<?php

namespace Janwebdev\TranslatableEntityBundle\Tests;

use Janwebdev\TranslatableEntityBundle\Model\TranslatingInterface;
use Janwebdev\TranslatableEntityBundle\Model\TranslatableInterface;

abstract class AbstractTranslation implements TranslatingInterface
{
    public function setLocale($string)
    {

    }

    public function getLocale()
    {

    }

    public function setTranslatable(TranslatableInterface $translatable)
    {

    }

    public function getCustom()
    {

    }
}
