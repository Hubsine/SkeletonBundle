<?php

namespace Hubsine\SkeletonBundle\Entity\Appearance;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Hubsine\SkeletonBundle\Validator\Constraints\UniqueEntry;

/**
 * @author Hubsine <contact@hubsine.com>
 * 
 * @ORM\Entity(repositoryClass="Hubsine\SkeletonBundle\Repository\Appearance\SiteRepository")
 * 
 * @UniqueEntry(groups={"create"})
 */
class Site
{
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
    
    public function __get($name) 
    {
        #call_user_func_array([__CLASS__ . 'Translation', 'get' . ucfirst($name)], []);
    }
}
