<?php

namespace Hubsine\SkeletonBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Hubsine\SkeletonBundle\Twig\SkeletonVariable;

/**
 * SkeletonVariableEvent
 *
 * @author Hubsine <contact@hubsine.com>
 */
class SkeletonVariableEvent extends Event
{
    private $skeletonVariable;
    
    public function __construct(SkeletonVariable $skeletonVariable) 
    {
        $this->skeletonVariable     = $skeletonVariable;
    }
    
    public function getSkeletonVariable() : SkeletonVariable
    {
        return $this->skeletonVariable;
    }
}
