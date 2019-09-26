<?php

namespace Hubsine\SkeletonBundle\Twig;

use Doctrine\Common\Persistence\ManagerRegistry as ManagerRegistryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Hubsine\SkeletonBundle\Entity\Appearance as AppearanceEntity;
use Hubsine\SkeletonBundle\HubsineSkeletonBundleEvents;
use Hubsine\SkeletonBundle\Event\SkeletonVariableEvent;

/**
 * SkeletonVariable
 *
 * @author Hubsine <contact@hubsine.com>
 */
class SkeletonVariable 
{
    /**
     * @var ManagerRegistryInterface
     */
    private $doctrine;
    
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;
    
    private $variables;

    public function __construct(ManagerRegistryInterface $doctrine, EventDispatcherInterface $eventDispatcher)
    {
        $this->doctrine         = $doctrine;
        $this->eventDispatcher  = $eventDispatcher;
        $this->variables        = [];
        
        $this->build();
    }
    
    private function build()
    {
        $site = $this->doctrine
            ->getRepository(AppearanceEntity\SiteTranslation::class)
            ->findOne();
        
        if( $site === null) 
        {
            $site = new AppearanceEntity\SiteTranslation();
            $site->setTranslatable(new AppearanceEntity\Site());
        }
        
        $logo = $this->doctrine
            ->getRepository(AppearanceEntity\Logo::class)
            ->findOneBy([]);
        
        if( $logo === null ? $logo = new AppearanceEntity\Logo() : $logo);
        
        $socialNetwork = $this->doctrine
            ->getRepository(AppearanceEntity\SocialNetwork::class)
            ->findAll();
        
        if( $socialNetwork === null ? $socialNetwork = [] : $socialNetwork);
        
        $this->addVariable('site', $site);
        $this->addVariable('logo', $logo);
        $this->addVariable('socialNetwork', $socialNetwork);
        
        $event  = new SkeletonVariableEvent($this);
        $this->eventDispatcher->dispatch(HubsineSkeletonBundleEvents::HUBSINE_SKELETON_VARIABLE, $event);
    }
    
    public function getVariables() : array
    {
        return $this->variables;
    }

    public function addVariable(string $variableName, $variableValue)
    {
        if( ! in_array( $variableName, $this->variables, true ) )
        {
            $this->variables[$variableName] = $variableValue;
        }
    }
    
    public function removeVariable(string $variableName)
    {
        if( array_key_exists( $variableName, $this->variables ) )
        {
            unset($this->variables[$variableName]);
        }
    }

    public function __call($name, array $arguments) 
    {
        if(array_key_exists($name, $this->variables) )
        {
            return $this->variables[$name];
        }
        
        return null;
    }
}
