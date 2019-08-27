<?php

namespace App\Entity\Appearance;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @author Hubsine <contact@hubsine.com>
 * 
 * @ORM\Entity(repositoryClass="App\Repository\Appearance\SiteRepository")
 * 
 * @Vich\Uploadable
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
    
    /**
     * @var string
     * 
     * @ORM\Column(name="slogan", type="string", nullable=false)
     * 
     * @Assert\NotBlank()
     */
    private $slogan;

    /**
     * @var string
     * 
     * @ORM\Column(name="description", type="string", nullable=false)
     * 
     * @Assert\NotBlank()
     */
    private $description;
    
    /**
     * @var \App\Entity\Appearance\Logo
     * 
     * @ORM\OneToOne(targetEntity="\App\Entity\Appearance\Logo", orphanRemoval=true, cascade={"all"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     * 
     * @Assert\NotBlank(message="assert.not_blank", groups={"new"})
     * @Assert\Type(type="\App\Entity\Appearance\Logo", groups={"new"})
     * @Assert\Valid()
     */
    private $logo;
    
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
     * Get slogan 
     * 
     * @return string
     */
    public function getSlogan() 
    {
        return $this->slogan;
    }
    
    /**
     * Get description
     * 
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
    
    /**
     * Set slogan
     * 
     * @param string $slogan
     */
    public function setSlogan($slogan) 
    {
        $this->slogan = $slogan;
    }

    /**
     * Set description
     * 
     * @param string $description
     */
    public function setDescription($description) 
    {
        $this->description = $description;
    }
    
    /**
     * Set logo
     *
     * @param \App\Entity\AppearanceLogo $logo
     *
     * @return AppearanceLogo
     */
    public function setLogo(\App\Entity\Appearance\Logo $logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return \App\Entity\Appearance\Logo
     */
    public function getLogo()
    {
        return $this->logo;
    }
}
