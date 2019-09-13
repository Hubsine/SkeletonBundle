<?php

namespace Hubsine\SkeletonBundle\Entity\Contact;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Hubsine\SkeletonBundle\Repository\Contact\FormRepository")
 */
class Form
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
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $lastName;

    /**
     * @ORM\Column(type="text")
     * 
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $message;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
}
