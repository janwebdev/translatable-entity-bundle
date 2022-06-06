<?php

namespace Janwebdev\TranslatableEntityBundle\Mapping\Event\Adapter\ORM;

use Janwebdev\TranslatableEntityBundle\Mapping\Event\Adapter\EventAdapterInterface;
use Doctrine\Common\EventArgs;
use Doctrine\ORM\Proxy\Proxy;

class DoctrineAdapter implements EventAdapterInterface
{
    /**
     * {@inheritDoc}
     */
    public function getObject(EventArgs $e): ?object
    {
        return $e->getEntity();
    }

    /**
     * {@inheritDoc}
     */
    public function getReflectionClass($obj): \ReflectionClass
    {
        if ($obj instanceof Proxy) {
            return new \ReflectionClass(get_parent_class($obj));
        }

        return new \ReflectionClass($obj);
    }
}
