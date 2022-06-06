<?php

namespace Janwebdev\TranslatableEntityBundle\Listener;

use Janwebdev\TranslatableEntityBundle\Locale\LocaleInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class LocaleListener
{
    private LocaleInterface $locale;

    public function __construct(LocaleInterface $locale)
    {
        $this->locale = $locale;
    }

    public function setLocale(RequestEvent $event): void
    {
        $this->locale->setLocale($event->getRequest()->getLocale());
    }
}
