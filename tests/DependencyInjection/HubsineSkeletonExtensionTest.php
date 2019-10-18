<?php

namespace Hubsine\SkeletonBundle\Tests\DependencyInjection;

use Hubsine\SkeletonBundle\Test\AbstractWebTestCase;

class HubsineSkeletonExtensionTest extends AbstractWebTestCase
{
    /**
     * @dataProvider provideServicesId
     */
    public function testLoadFullConfig($servicesId)
    {
        self::bootKernel();
        
        $container = self::$kernel->getContainer();
        
        // Services are loaded
        foreach ($servicesId as $serviceId)
        {
            $this->assertTrue($container->has($serviceId));
        }
        
    }
    
    public function testGlobalParameters()
    {
        self::bootKernel();
        
        $container = self::$kernel->getContainer();
        
        $this->assertTrue($container->hasParameter('locale'));
        $this->assertSame('fr', $container->getParameter('locale'));
    }

    public function provideServicesId()
    {
        return 
        [
            [
                [
                    'hubsine_skeleton.validator.unique_entry',
                    'hubsine_skeleton.event_subscriber.table_prefix',
                    'hubsine_skeleton.event_subscriber.maintenance',
                    'hubsine_skeleton.naming.smart_unique_namer',
                    'hubsine_skeleton.twig.variable',
                    'swiftmailer.mailer.skeleton'
                ]
            ]
        ];
    }
}
