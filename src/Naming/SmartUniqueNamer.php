<?php

namespace Hubsine\SkeletonBundle\Naming;

use Behat\Transliterator\Transliterator;
use Vich\UploaderBundle\Naming\NamerInterface;
use Vich\UploaderBundle\Mapping\PropertyMapping;

/**
 * SmartUniqueNamer
 *
 * @author Hubsine <contact@hubsine.com>
 */
final class SmartUniqueNamer implements NamerInterface
{
    public function name($object, PropertyMapping $mapping): string
    {
        $file = $mapping->getFile($object);
        $originalName = $file->getClientOriginalName();
        $originalExtension = \pathinfo($originalName, PATHINFO_EXTENSION);
        $originalBasename = \basename($originalName, '.'.$originalExtension);
        $originalBasename = Transliterator::transliterate($originalBasename);

        return \sprintf('%s%s.%s', $originalBasename, \str_replace('.', '', \uniqid('-', true)), $originalExtension);
    }
    
}
