<?php

namespace App\Traits\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;

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
     * @ORM\Embedded(class="Vich\UploaderBundle\Entity\File")
     *
     * @var EmbeddedFile
     */
    private $media;
    
    /**
     * @ORM\Column(name="original_name", nullable=true)
     * 
     * @Assert\Type(type="string", message="assert.type")
     */
    private $originalName;
    
    /**
     * Set media
     *
     * @param string $media
     *
     * @return Media
     */
    public function setMedia(EmbeddedFile $media)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return string
     */
    public function getMedia(): ?EmbeddedFile
    {
        return $this->media;
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
