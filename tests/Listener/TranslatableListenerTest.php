<?php

namespace Janwebdev\TranslatableEntityBundle\Tests\Listener;

use Janwebdev\TranslatableEntityBundle\Listener\TranslatableListener;
use PHPUnit\Framework\TestCase;
use Janwebdev\TranslatableEntityBundle\Mapping\Event\Adapter\EventAdapterInterface;
use Janwebdev\TranslatableEntityBundle\Locale\LocaleInterface;
use Doctrine\Common\EventArgs;
use Janwebdev\TranslatableEntityBundle\Model\TranslatableInterface;

class TranslatableListenerTest extends TestCase
{
	protected $adapter;
	protected $locale;
	protected $args;
	protected $entity;
	protected $dummy;
	protected $listener;

    protected function setUp(): void
    {
        $this->adapter  = $this->getMockBuilder(EventAdapterInterface::class)
                ->disableOriginalConstructor()->getMock();
        $this->locale   = $this->getMockBuilder(LocaleInterface::class)
                ->disableOriginalConstructor()->getMock();
        $this->args     = $this->getMockBuilder(EventArgs::class)
                ->disableOriginalConstructor()->getMock();                
        $this->entity   = $this->getMockBuilder(TranslatableInterface::class)
                ->disableOriginalConstructor()->getMock();       
        $this->dummy    = $this->getMockBuilder('Dummy')
                ->disableOriginalConstructor()->getMock();       
        
        $this->listener = new TranslatableListener($this->adapter, $this->locale);
    }
    
    public function testPostLoad(): void
    {        
        $this->adapter->expects($this->once())->method('getObject')
                ->with($this->args)
                ->willReturn($this->entity);
        $this->entity->expects($this->once())->method('setLocale')
                ->with($this->locale);
        
        $this->listener->postLoad($this->args);
    }
    
    public function testPostLoadInterfaceNotCorrect(): void
    {        
        $this->adapter->expects($this->once())->method('getObject')
                ->with($this->args)
                ->willReturn($this->dummy);
        $this->entity->expects($this->never())
                ->method('setLocale');
        
        $this->listener->postLoad($this->args);
    }
}
