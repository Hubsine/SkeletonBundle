<?php

namespace Hubsine\SkeletonBundle\Twig;

use Doctrine\Common\Persistence\ManagerRegistry as ManagerRegistryInterface;
use Hubsine\SkeletonBundle\Entity\Appearance as AppearanceEntity;

/**
 * SkeletonVariable
 *
 * @author Hubsine <contact@hubsine.com>
 */
class SkeletonVariable 
{
    private $doctrine;
    private $site;
    private $logo;
    private $socialNetwork;
    
    public function __construct(ManagerRegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
        
        $this->build();
    }
    
    private function build()
    {
        $this->site = $this->doctrine
            ->getRepository(AppearanceEntity\SiteTranslation::class)
            ->findOne();
        
        $this->logo = $this->doctrine
            ->getRepository(AppearanceEntity\Logo::class)
            ->findOneBy([]);
        
        $this->socialNetwork = $this->doctrine
            ->getRepository(AppearanceEntity\SocialNetwork::class)
            ->findOneBy([]);
    }
    
    public function getSite()
    {
        return $this->site;
    }
    
    public function getLogo()
    {
        return $this->logo;
    }
    
    public function getSocialNetwork()
    {
        return $this->socialNetwork;
    }
}
