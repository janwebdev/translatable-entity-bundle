<?php

namespace Janwebdev\TranslatableEntityBundle\Listener;

use Doctrine\Common\EventArgs;
use Janwebdev\TranslatableEntityBundle\Locale\LocaleInterface;
use Janwebdev\TranslatableEntityBundle\Model\TranslatableInterface;
use Janwebdev\TranslatableEntityBundle\Mapping\Event\Adapter\EventAdapterInterface;


class TranslatableListener
{
    protected LocaleInterface $locale;
    protected EventAdapterInterface $adapter;

    public function __construct(EventAdapterInterface $adapter, LocaleInterface $locale)
    {
        $this->adapter  = $adapter;
        $this->locale   = $locale;
    }

    public function postLoad(EventArgs $args): void
    {
        $entity = $this->adapter->getObject($args);

        if ($entity instanceof TranslatableInterface) {
            $entity->setLocale($this->locale);
        }
    }
}
