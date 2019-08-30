<?php

namespace Hubsine\SkeletonBundle\Traits\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Hubsine\SkeletonBundle\Traits\Entity\MediaTrait;


/**
 * Description of ImageTrait
 * 
 * @author Hubsine <contact@hubsine.com>
 */
trait ImageTrait
{
    use MediaTrait;
    
    /**
     * @var \Symfony\Component\HttpFoundation\File\UploadedFile
     * 
     * @Vich\UploadableField(
     *  mapping="site_appearance", 
     *  fileNameProperty="name", 
     *  size="size", 
     *  mimeType="mimeType", 
     *  originalName="originalName"
     * )
     * 
     * @Assert\Image(
     *  maxSize="2M", 
     *  maxSizeMessage="assert.file.max_size", 
     *  mimeTypesMessage="assert.file.mime_types"
     * )
     */
    private $file;

    /**
     * @var string 
     * 
     * @ORM\Column(name="mime_type", type="string")
     */
    private $mimeType;

    /**
     * @var integer
     * 
     * @ORM\Column(name="size", type="decimal")
     */
    private $size;

    /**
     * Set mimeType
     *
     * @param string $mimeType
     *
     * @return Image
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get mimeType
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Set size
     *
     * @param string $size
     *
     * @return Image
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }
    
    /**
     * Set File
     * 
     * @param File|UploadedFile $file
     * @return $this
     */
    public function setFile(?File $file = null)
    {
        $this->file = $file;
        
        if ($file) 
        {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
        
        return $this;
    }

    /**
     * Get File 
     * 
     * @return \Symfony\Component\HttpFoundation\File\UploadedFile
     */
    public function getFile(): ?File
    {
        return $this->file;
    }
}
