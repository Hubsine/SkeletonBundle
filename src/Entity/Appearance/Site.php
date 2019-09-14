<?php

namespace Hubsine\SkeletonBundle\Entity\Appearance;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Hubsine\SkeletonBundle\Validator\Constraints\UniqueEntry;
use Hubsine\SkeletonBundle\Traits\Entity\MagicGetTrait;

/**
 * @author Hubsine <contact@hubsine.com>
 * 
 * @ORM\Entity(repositoryClass="Hubsine\SkeletonBundle\Repository\Appearance\SiteRepository")
 * 
 * @UniqueEntry(groups={"create"})
 */
class Site
{
    use ORMBehaviors\Translatable\Translatable;
    use MagicGetTrait;
    
    /**
     * @Assert\Valid()
     */
    protected $translations;
        
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * 
     * @ORM\Column(name="name", type="string", nullable=false)
     * 
     * @Assert\NotBlank()
     */
    private $name;
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    /**
     * Get name 
     * 
     * @return string
     */
    public function getName() 
    {
        return $this->name;
    }
    
    /**
     * Set name
     * 
     * @param string $name
     */
    public function setName($name) 
    {
        $this->name = $name;
    }
}
