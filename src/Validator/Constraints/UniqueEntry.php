<?php

namespace Hubsine\SkeletonBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * UniqueEntry
 *
 * @Annotation
 * 
 * @author Hubsine <contact@hubsine.com>
 */
class UniqueEntry extends Constraint
{
    public $message = 'There can only be one entry for {{ entry_class }}.';
    public $em = null;
    public $entityClass = null;
    public $repositoryMethod = 'count';
    
    /**
     * {@inheritdoc}
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
    
    /**
     * The validator must be defined as a service with this name.
     *
     * @return string
     */
    public function validatedBy()
    {
        return get_class($this) . 'Validator';
    }
}
