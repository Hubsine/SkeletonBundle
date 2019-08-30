<?php

namespace Hubsine\SkeletonBundle\Entity\Appearance;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
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
    const VICH_MAPPING = 'site_logo';
    
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
