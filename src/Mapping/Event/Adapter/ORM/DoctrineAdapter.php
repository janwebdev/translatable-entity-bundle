<?php

namespace Janwebdev\TranslatableEntityBundle\Mapping\Event\Adapter\ORM;

use Janwebdev\TranslatableEntityBundle\Mapping\Event\Adapter\EventAdapterInterface;
use Doctrine\Common\EventArgs;
use Doctrine\ORM\Proxy\Proxy;

class DoctrineAdapter implements EventAdapterInterface
{
    public function getObject(EventArgs $e): ?object
    {
        return $e->getEntity();
    }

    public function getReflectionClass(object $obj): \ReflectionClass
    {
        if ($obj instanceof Proxy) {
            $parentClass = get_parent_class($obj);
            if ($parentClass === false) {
                throw new \RuntimeException('Unable to get parent class of proxy');
            }
            return new \ReflectionClass($parentClass);
        }

        return new \ReflectionClass($obj);
    }
}
