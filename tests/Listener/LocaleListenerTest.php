<?php

namespace Janwebdev\TranslatableEntityBundle\Tests\Listener;

use Janwebdev\TranslatableEntityBundle\Listener\LocaleListener;
use Janwebdev\TranslatableEntityBundle\Locale\LocaleInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use PHPUnit\Framework\TestCase;

class LocaleListenerTest extends TestCase
{
	protected $event;
	protected $locale;
	protected $request;
	protected $listener;

    protected function setUp(): void
    {
        $this->event = $this->getMockBuilder(RequestEvent::class)
                ->disableOriginalConstructor()->getMock();
        $this->locale = $this->getMockBuilder(LocaleInterface::class)
                ->disableOriginalConstructor()->getMock();
        $this->request = $this->getMockBuilder(Request::class)
                ->disableOriginalConstructor()->getMock();

        $this->listener = new LocaleListener($this->locale);

        parent::setUp();
    }
    
    public function testOnKernelRequest(): void
    {
        $this->event->expects($this->once())->method('getRequest')
                ->willReturn($this->request);
        $this->request->expects($this->once())->method('getLocale')
                ->willReturn('en');
        $this->locale->expects($this->once())->method('setLocale')
                ->with('en');
        
        $this->listener->setLocale($this->event);
    }
}
