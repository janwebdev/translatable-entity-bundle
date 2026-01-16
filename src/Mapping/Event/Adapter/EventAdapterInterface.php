<?php

namespace Janwebdev\TranslatableEntityBundle\Mapping\Event\Adapter;

use Doctrine\Common\EventArgs;

interface EventAdapterInterface
{
    /**
     * Gets the mapped object from the event arguments.
     */
    public function getObject(EventArgs $e): ?object;

    /**
     * Gets the reflection class for the object taking proxies into account.
     */
    public function getReflectionClass(object $obj): \ReflectionClass;
}
