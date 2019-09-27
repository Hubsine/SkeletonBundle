<?php

namespace Hubsine\SkeletonBundle\Test;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * AbstractWebTestCase
 *
 * @author Hubsine <contact@hubsine.com>
 */
abstract class AbstractWebTestCase extends WebTestCase
{
    /**
     *
     * @var Symfony\Component\DependencyInjection\ContainerInterface|null
     */
    protected static $container;
    
    public function __construct($name = null, $data = array(), $dataName = '') 
    {
        parent::__construct($name, $data, $dataName);
        
        static::$kernel = self::bootKernel();
        static::$container = static::$kernel->getContainer();
    }
}
