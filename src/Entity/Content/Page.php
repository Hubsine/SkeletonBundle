<?php

namespace Hubsine\SkeletonBundle\Entity\Content;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Hubsine\SkeletonBundle\Validator\Constraints\UniqueEntry;
use Hubsine\SkeletonBundle\Traits\Entity\MagicGetTrait;

/**
 * @ORM\Entity(repositoryClass="Hubsine\SkeletonBundle\Repository\Content\PageRepository")
 * 
 * @UniqueEntity("tag")
 */
class Page
{
    const AVAIBLES_TAGS = ['a-propos', 'contact', 'cgu', 'cgv', 'mentions-legales', 'points-distribution'];
    
    use ORMBehaviors\Translatable\Translatable;
    use MagicGetTrait;
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * 
     * @Assert\NotBlank()
     * @Assert\Choice(callback="getAvaiblesTags")
     */
    private $tag;
    
    public static function getAvaiblesTags()
    {
        return self::AVAIBLES_TAGS;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }
}
