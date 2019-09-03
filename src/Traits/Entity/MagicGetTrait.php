<?php

namespace Hubsine\SkeletonBundle\Traits\Entity;

/**
 *
 * @author Hubsine <contact@hubsine.com>
 */
trait MagicGetTrait 
{
    public function __get($name)
    {
        $method     = 'get'. ucfirst($name);
        $arguments  = [];
        
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }
}
