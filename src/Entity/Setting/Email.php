<?php

namespace Hubsine\SkeletonBundle\Entity\Setting;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Hubsine\SkeletonBundle\Validator\Constraints\UniqueEntry;

/**
 * 
 * Email 
 * 
 * @ORM\Entity(repositoryClass="Hubsine\SkeletonBundle\Repository\Setting\EmailRepository")
 * 
 * @UniqueEntry(groups={"create"})
 */
class Email
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\NotBlank()
     * @Assert\Email(checkMX=true, checkHost=true)
     */
    private $fromEmail;
    
    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\NotBlank()
     * @Assert\Email(checkMX=true, checkHost=true)
     */
    private $toEmail;

    /**
     * @ORM\Column(type="string", length=155)
     * 
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $fromName;

    /**
     * @ORM\Column(type="string", length=155)
     * 
     * @Assert\NotBlank()
     * @Assert\Email(checkMX=true, checkHost=true)
     */
    private $responseEmail;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFromEmail(): ?string
    {
        return $this->fromEmail;
    }

    public function setFromEmail(string $fromEmail): self
    {
        $this->fromEmail = $fromEmail;

        return $this;
    }
    
    public function getToEmail(): ?string
    {
        return $this->toEmail;
    }

    public function setToEmail(string $toEmail): self
    {
        $this->toEmail = $toEmail;

        return $this;
    }

    public function getFromName(): ?string
    {
        return $this->fromName;
    }

    public function setFromName(string $fromName): self
    {
        $this->fromName = $fromName;

        return $this;
    }

    public function getResponseEmail(): ?string
    {
        return $this->responseEmail;
    }

    public function setResponseEmail(string $responseEmail): self
    {
        $this->responseEmail = $responseEmail;

        return $this;
    }
}
