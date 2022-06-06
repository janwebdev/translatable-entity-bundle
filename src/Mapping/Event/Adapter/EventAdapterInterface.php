<?php

namespace Janwebdev\TranslatableEntityBundle\Mapping\Event\Adapter;

use Doctrine\Common\EventArgs;

interface EventAdapterInterface
{
    /**
     * Gets the mapped object from the event arguments.
     *
     * @param  EventArgs $e The event arguments.
     * @return object    The mapped object.
     */
    public function getObject(EventArgs $e): ?object;


    /**
     * Gets the reflection class for the object taking
     * proxies into account.
     *
     * @param  object           $obj The object.
     * @return \ReflectionClass The reflection class.
     */
    public function getReflectionClass($obj): \ReflectionClass;
}
