<?php

namespace Hubsine\SkeletonBundle\Entity\Setting;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity(repositoryClass="Hubsine\SkeletonBundle\Repository\Setting\MaintenanceTranslationRepository")
 */
class MaintenanceTranslation
{
    use ORMBehaviors\Translatable\Translation;
    
    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * 
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $content;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
