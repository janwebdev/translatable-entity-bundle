<?php

namespace Janwebdev\TranslatableEntityBundle\Model;

use Janwebdev\TranslatableEntityBundle\Model\TranslatableInterface;

interface TranslatingInterface
{
    public function setLocale($string);
    public function getLocale();
    public function setTranslatable(TranslatableInterface $translatable);
}
