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
    
    private $site;
    
    private $logo;
    
    private $socialNetwork;
    
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
        $this->site = $this->doctrine
            ->getRepository(AppearanceEntity\SiteTranslation::class)
            ->findOne();
        
        if( $this->site === null) 
        {
            $this->site = new AppearanceEntity\SiteTranslation();
            $this->site->setTranslatable(new AppearanceEntity\Site());
        }
        
        $this->logo = $this->doctrine
            ->getRepository(AppearanceEntity\Logo::class)
            ->findOneBy([]);
        
        if( $this->logo === null ? $this->logo = new AppearanceEntity\Logo() : $this->logo);
        
        $this->socialNetwork = $this->doctrine
            ->getRepository(AppearanceEntity\SocialNetwork::class)
            ->findAll();
        
        if( $this->socialNetwork === null ? $this->socialNetwork = [] : $this->socialNetwork);
        
        $event  = new SkeletonVariableEvent($this);
        $this->eventDispatcher->dispatch(HubsineSkeletonBundleEvents::HUBSINE_SKELETON_VARIABLE, $event);
    }
    
    public function getSite() : AppearanceEntity\SiteTranslation
    {
        return $this->site;
    }
    
    public function getLogo() : AppearanceEntity\Logo
    {
        return $this->logo;
    }
    
    public function getSocialNetwork() : array
    {
        return $this->socialNetwork;
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
