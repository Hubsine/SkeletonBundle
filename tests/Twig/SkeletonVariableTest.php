<?php

namespace Hubsine\SkeletonBundle\Tests\Twig;

use Hubsine\SkeletonBundle\Test\AbstractWebTestCase;
use Hubsine\SkeletonBundle\Entity\Appearance as AppearanceEntity;

/**
 * SkeletonVariable
 *
 * @author Hubsine <contact@hubsine.com>
 */
class SkeletonVariableTest extends AbstractWebTestCase
{
    public function testBuild()
    {
        $kernel             = self::bootKernel();
        $container          = $kernel->getContainer();
        $skeletonVariable   = $container->get('hubsine.skeleton.variable');
        
        // Defaults values
        $this->assertInstanceOf(AppearanceEntity\SiteTranslation::class, $site = $skeletonVariable->site);
        $this->assertInstanceOf(AppearanceEntity\Logo::class, $logo = $skeletonVariable->logo);
        $this->assertIsArray($socialNetwork = $skeletonVariable->socialNetwork);
        
        // Variable doest exist
        $this->assertNull($skeletonVariable->teszefhezf);
        
        
        // Add and Remove assertion
        $skeletonVariable->addVariable('Foo', 'Foo');
        $this->assertEquals('Foo', $skeletonVariable->Foo);
        
        $skeletonVariable->removeVariable('Foo');
        $this->assertNull($skeletonVariable->Foo);
    }
}
