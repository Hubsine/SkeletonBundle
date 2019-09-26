<?php

namespace Hubsine\SkeletonBundle\Entity\Setting;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Hubsine\SkeletonBundle\Validator\Constraints\UniqueEntry;

/**
 * 
 * EmailTransport
 * 
 * @ORM\Entity(repositoryClass="Hubsine\SkeletonBundle\Repository\Setting\EmailTransportRepository")
 * 
 * @UniqueEntry(groups={"create"})
 */
class EmailTransport
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=155)
     * 
     * @Assert\Type(type="string")
     */
    private $host;

    /**
     * @ORM\Column(type="integer")
     * 
     * @Assert\NotBlank()
     * @Assert\Type(type="integer")
     */
    private $port;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\NotBlank()
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=10)
     * 
     * @Assert\choice(callback="getEncryptions")
     */
    private $encryption;

    /**
     * @ORM\Column(type="string", length=50)
     * 
     * @Assert\choice(callback="getAuthModes")
     */
    private $authMode;
    
    
    public static function getEncryptions()
    {
        return array('tls', 'ssl');
    }
    
    public static function getAuthModes()
    {
        return array('plain', 'login', 'cram-md5');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHost(): ?string
    {
        return $this->host;
    }

    public function setHost(string $host): self
    {
        $this->host = $host;

        return $this;
    }

    public function getPort(): ?int
    {
        return $this->port;
    }

    public function setPort(int $port): self
    {
        $this->port = $port;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEncryption(): ?string
    {
        return $this->encryption;
    }

    public function setEncryption(string $encryption): self
    {
        $this->encryption = $encryption;

        return $this;
    }

    public function getAuthMode(): ?string
    {
        return $this->authMode;
    }

    public function setAuthMode(string $authMode): self
    {
        $this->authMode = $authMode;

        return $this;
    }
}
