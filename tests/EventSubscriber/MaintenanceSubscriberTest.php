<?php

namespace Hubsine\SkeletonBundle\Tests\EventSubscriber;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Response;
use Hubsine\SkeletonBundle\Test\AbstractWebTestCase;
use Hubsine\SkeletonBundle\EventSubscriber\MaintenanceSubscriber;

class MaintenanceSubscriberTest extends AbstractWebTestCase
{
    private $maintenanceSubscriber;
    private $getResponseEvent;
    private $excludeRoutes = ['fos_user_security_login', '_profiler', '_wdt'];

	public function setUp()
	{
		$this->maintenanceSubscriber  = $this->getMockBuilder(MaintenanceSubscriber::class)
            ->disableOriginalConstructor()
            ->setMethods(['isMaintenanceMode', 'isAdmin', 'getExcludeRoutes', 'getMaintenanceView', 'getCurrentRouteName'])
            ->getMock()
            ;

        $this->getResponseEvent = $this->getMockBuilder(GetResponseEvent::class)
            ->disableOriginalConstructor()
            ->setMethods(['Foo']) // Foo est utilisé pour que le dummy devient unn stub, sans cela les méthodes comme hasResponse retournent tjrs null
            ->getMock();    

        static::bootKernel();
            
	}
    

    /**
     * testOnKerneleRequest
     *
     * @dataProvider provideConditionalsRequired
     */
    public function testOnKerneleRequest($onMaintenanceMode, $isAdmin, $onExcludeRoute, $maintenancePage)
    {
      
        $this->maintenanceSubscriber
            ->method('getCurrentRouteName')
            ->willReturn($onExcludeRoute ? $this->excludeRoutes[ array_rand( $this->excludeRoutes ) ] : 'Foo');
        
        $this->maintenanceSubscriber
            ->method('isMaintenanceMode')
            ->willReturn($onMaintenanceMode);
    

    
        $this->maintenanceSubscriber
            ->method('isAdmin')
            ->willReturn($isAdmin);
       
            $this->maintenanceSubscriber
            ->method('getExcludeRoutes')
            ->willReturn( $onExcludeRoute ? $this->excludeRoutes : [] );

        if( $maintenancePage )
        {
            $this->maintenanceSubscriber
                ->method('getMaintenanceView')
                ->willReturn('Foo');
        }
        

        $this->maintenanceSubscriber->onKernelRequest($this->getResponseEvent);

        $this->assertSame($maintenancePage, $this->getResponseEvent->hasResponse() );
    }

    public function provideConditionalsRequired()
    {
        return [
            [true, true, true, false],  
            [false, true, true, false],
            [false, true, false, false],
            [false, false, true, false],
            [true, true, false, false],
            [true, false, true, false],
            [true, false, false, true],

        ];
    }
    
    
            
}
