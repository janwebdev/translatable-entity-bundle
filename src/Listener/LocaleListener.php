<?php

namespace Janwebdev\TranslatableEntityBundle\Listener;

use Janwebdev\TranslatableEntityBundle\Locale\LocaleInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

#[AsEventListener(event: KernelEvents::REQUEST, method: 'setLocale', priority: 16)]
class LocaleListener
{
    public function __construct(
        private readonly LocaleInterface $locale
    ) {
    }

    public function setLocale(RequestEvent $event): void
    {
        $this->locale->setLocale($event->getRequest()->getLocale());
    }
}
