<?php

namespace Hubsine\SkeletonBundle\Entity\Appearance;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractTranslation;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SiteTranslation
 *
 * @ORM\Table(name="site_translations", indexes={
 *      @ORM\Index(name="site_translation_idx", columns={"locale", "object_class", "field", "foreign_key"})
 * })
 * @ORM\Entity(repositoryClass="Gedmo\Translatable\Entity\Repository\TranslationRepository")
 * 
 * @author Hubsine <contact@hubsine.com>
 */
class SiteTranslation extends AbstractTranslation
{
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
}
