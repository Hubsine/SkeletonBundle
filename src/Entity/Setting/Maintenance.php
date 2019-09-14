<?php

namespace Hubsine\SkeletonBundle\Entity\Setting;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Hubsine\SkeletonBundle\Traits\Entity\MagicGetTrait;
use Hubsine\SkeletonBundle\Validator\Constraints\UniqueEntry;

/**
 * @ORM\Entity(repositoryClass="Hubsine\SkeletonBundle\Repository\Setting\MaintenanceRepository")
 * 
 * @UniqueEntry(groups={"create"})
 */
class Maintenance
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
     * @ORM\Column(type="boolean")
     * 
     * @Assert\NotBlank()
     * @Assert\Type(type="boolean")
     */
    private $enable;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEnable(): ?bool
    {
        return $this->enable;
    }

    public function setEnable(bool $enable): self
    {
        $this->enable = $enable;

        return $this;
    }
}
