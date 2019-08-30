<?php

namespace Hubsine\SkeletonBundle\Traits\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Description of MediaTrait
 * 
 * @author Hubsine <contact@hubsine.com>
 */
trait MediaTrait
{
    /**
     * @var string 
     * 
     * @ORM\Column(name="name", type="string", nullable=false)
     *
     * @Assert\Type(type="string", message="assert.type")
     */
    private $name;
    
    /**
     * @ORM\Column(name="original_name", nullable=false)
     * 
     * @Assert\Type(type="string", message="assert.type")
     */
    private $originalName;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedAt;
    
    /**
     * Set name
     * 
     * @param string $name
     *
     * @param string $media
     *
     * @return Media
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
    
    public function getOriginalName()
    {
        return $this->originalName;
    }

    public function setOriginalName(string $originalName = null)
    {
        $this->originalName = $originalName;
    }
}
