<?php

namespace Janwebdev\TranslatableEntityBundle\Tests\Listener;

use Janwebdev\TranslatableEntityBundle\Listener\TranslatableListener;
use Janwebdev\TranslatableEntityBundle\Locale\Locale;

class EntityListenerTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->adapter  = $this->getMockBuilder('Janwebdev\TranslatableEntityBundle\Mapping\Event\Adapter\EventAdapterInterface')
                ->disableOriginalConstructor()->getMock();
        $this->locale   = $this->getMockBuilder('Janwebdev\TranslatableEntityBundle\Locale\LocaleInterface')
                ->disableOriginalConstructor()->getMock();
        $this->args     = $this->getMockBuilder('Doctrine\Common\EventArgs')
                ->disableOriginalConstructor()->getMock();                
        $this->entity   = $this->getMockBuilder('Janwebdev\TranslatableEntityBundle\Model\TranslatableInterface')
                ->disableOriginalConstructor()->getMock();       
        $this->dummy    = $this->getMockBuilder('Dummy')
                ->disableOriginalConstructor()->getMock();       
        
        $this->listener = new TranslatableListener($this->adapter, $this->locale);
    }
    
    public function testPostLoad()
    {        
        $this->adapter->expects($this->once())->method('getObject')
                ->with($this->args)
                ->will($this->returnValue($this->entity));        
        $this->entity->expects($this->once())->method('setLocale')
                ->with($this->locale);
        
        $this->listener->postLoad($this->args);
    }
    
    public function testPostLoadInterfaceNotCorrect()
    {        
        $this->adapter->expects($this->once())->method('getObject')
                ->with($this->args)
                ->will($this->returnValue($this->dummy));        
        $this->entity->expects($this->never())
                ->method('setLocale');
        
        $this->listener->postLoad($this->args);
    }
}
