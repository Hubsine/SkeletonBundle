<?php

namespace Hubsine\SkeletonBundle\Tests\Tests\Event;

use Hubsine\SkeletonBundle\Test\AbstractWebTestCase;
use Hubsine\SkeletonBundle\Event\SkeletonVariableEvent;
use Hubsine\SkeletonBundle\Twig\SkeletonVariable;

class SkeletonVariableEventTest extends AbstractWebTestCase
{
    public function testGetSkeletonVariable()
    {
        $skeletonVariable = $this->getMockBuilder(SkeletonVariable::class)
                ->disableOriginalConstructor()
                ->getMock();
        
        $event = new SkeletonVariableEvent($skeletonVariable);
        
        $this->assertInstanceOf(SkeletonVariable::class, $event->getSkeletonVariable());
    }
}
