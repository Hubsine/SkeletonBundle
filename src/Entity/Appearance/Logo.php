<?php

namespace Hubsine\SkeletonBundle\Entity\Appearance;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Hubsine\SkeletonBundle\Validator\Constraints\UniqueEntry;
use Hubsine\SkeletonBundle\Traits\Entity\ImageTrait;
use Hubsine\SkeletonBundle\Entity\EntityInterface;
use Hubsine\SkeletonBundle\Entity\MediaInterface;

/**
 * Logo
 *
 * @ORM\Table(name="logo")
 * @ORM\Entity()
 * 
 * @Vich\Uploadable
 * 
 * @UniqueEntry(groups={"create"})
 */
class Logo implements EntityInterface, MediaInterface
{
    use ImageTrait;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var \Symfony\Component\HttpFoundation\File\UploadedFile
     * 
     * @Vich\UploadableField(
     *  mapping="site_logo", 
     *  fileNameProperty="media.name", 
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

    public function __construct() 
    {
        $this->media = new EmbeddedFile();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
