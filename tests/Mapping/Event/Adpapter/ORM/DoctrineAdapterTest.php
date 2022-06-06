<?php

namespace Janwebdev\TranslatableEntityBundle\Tests\Mapping\Event\Adpapter\ORM;

use Janwebdev\TranslatableEntityBundle\Mapping\Event\Adapter\ORM\DoctrineAdapter;
use Janwebdev\TranslatableEntityBundle\Tests\Translatable;
use Janwebdev\TranslatableEntityBundle\Tests\TranslatableProxy;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Proxy\Proxy;

class DoctrineAdapterTest extends TestCase
{
    public function testGetObject(): void
    {
        if (!class_exists(LifecycleEventArgs::class)) {
            $this->markTestSkipped('Doctrine\ORM\Event\LifecycleEventArgs does not exist.');
        } else {
            $args = $this->getMockBuilder(LifecycleEventArgs::class)
                    ->disableOriginalConstructor()->getMock();
            
            $adapter = new DoctrineAdapter();
            $args->expects($this->once())->method('getEntity');
            $adapter->getObject($args);
        }
    }
    
    public function testGetReflectionClass(): void
    {
        if (!interface_exists(Proxy::class)) {
            $this->markTestSkipped('Doctrine\ORM\Proxy\Proxy does not exist.');
        } else {
            $obj = new Translatable();
            $adapter = new DoctrineAdapter();
            $class = $adapter->getReflectionClass($obj);

            $this->assertEquals($class->getName(), get_class($obj));
        }
    }
    
    public function testGetReflectionClassProxy(): void
    {
        if (!interface_exists(Proxy::class)) {
            $this->markTestSkipped('Doctrine\ORM\Proxy\Proxy does not exist.');
        } else {
            $obj = new TranslatableProxy();
            $adapter = new DoctrineAdapter();
            $class = $adapter->getReflectionClass($obj);

            $this->assertEquals($class->getName(), get_parent_class($obj));
        }
    }
}
