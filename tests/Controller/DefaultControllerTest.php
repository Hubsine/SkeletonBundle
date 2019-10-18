<?php

namespace Hubsine\SkeletonBundle\Tests\Controller;

use Hubsine\SkeletonBundle\Test\AbstractWebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Routing\Router ;

class DefaultControllerTest extends AbstractWebTestCase
{
    public function testIndex()
    {
        $client = static::createClient([], [
            'HTTP_HOST'       => 'hubsine-skeleton.local'
        ]);
        
        $url        = $client->getContainer()->get('router')->generate('home', []);
        
        $client->request('GET', $url);
        
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        
    }
}
