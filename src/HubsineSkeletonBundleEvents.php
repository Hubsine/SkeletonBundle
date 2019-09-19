<?php

namespace Hubsine\SkeletonBundle;

/**
 * HubsineSkeletonBundleEvents
 *
 * @author Hubsine <contact@hubsine.com>
 */
class HubsineSkeletonBundleEvents 
{

    /**
     * Cet évènement est utilisé pour ajouter des variables aux variables super global twig Skeleton
     * 
     * @see Hubsine\SkeletonBundle\Twig\SkeletonVariable
     * 
     * @Event("Hubsine\SkeletonBundle\Event\SkeletonVariableEvent")
     */
    const HUBSINE_SKELETON_VARIABLE = 'hubsine.skeleton_variable';

}
