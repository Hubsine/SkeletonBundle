<?php

namespace Hubsine\SkeletonBundle\Entity\Content;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Hubsine\SkeletonBundle\Traits\Entity\MagicGetTrait;

/**
 * @ORM\Entity(repositoryClass="Hubsine\SkeletonBundle\Repository\Content\PageRepository")
 */
class Page
{
    const AVAIBLES_TAGS = ['a-propos', 'contact', 'cgu', 'cgv', 'mentions-legales', 'autre'];
    
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
    
    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        if( $this->tag !== 'autre' )
        {
            $uniqueEntity = new UniqueEntity(['fields'  => 'tag']);
            $uniqueEntity->entityClass = self::class;
            
            $errors = $context->getValidator()->validate($this, $uniqueEntity);
            
            if( $errors->count() > 0 )
            {
                $context->buildViolation($uniqueEntity->message)
                        ->atPath('tag')
                        ->addViolation();
            }
        }
    }
    
    public function __call($method, $arguments)
    {
        return \Symfony\Component\PropertyAccess\PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $method);
    }
}
