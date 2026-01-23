<?php

namespace Janwebdev\TranslatableEntityBundle\Listener;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\Common\EventArgs;
use Doctrine\ORM\Events;
use Janwebdev\TranslatableEntityBundle\Locale\LocaleInterface;
use Janwebdev\TranslatableEntityBundle\Model\TranslatableInterface;
use Janwebdev\TranslatableEntityBundle\Mapping\Event\Adapter\EventAdapterInterface;

#[AsDoctrineListener(event: Events::postLoad)]
class TranslatableListener
{
    public function __construct(
        private readonly EventAdapterInterface $adapter,
        private readonly LocaleInterface $locale
    ) {
    }

    public function postLoad(EventArgs $args): void
    {
        $entity = $this->adapter->getObject($args);

        if ($entity instanceof TranslatableInterface) {
            $entity->setLocale($this->locale);
        }
    }
}
