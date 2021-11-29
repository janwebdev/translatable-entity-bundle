<?php

namespace Janwebdev\TranslatableEntityBundle\Model;

use Janwebdev\TranslatableEntityBundle\Model\TranslatableInterface;

interface TranslatingInterface
{
    function setLocale($string);

    function getLocale();

    function setTranslatable(TranslatableInterface $translatable);
}
