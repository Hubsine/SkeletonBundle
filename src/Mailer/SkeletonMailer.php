<?php

namespace Hubsine\SkeletonBundle\Mailer;

use Doctrine\Common\Persistence\ManagerRegistry as ManagerRegistryInterface;
use Hubsine\SkeletonBundle\Entity\Setting\Email;
use Hubsine\SkeletonBundle\Entity\Setting\EmailTransport;

/**
 * SkeletonMailer
 *
 * @author Hubsine <contact@hubsine.com>
 */
class SkeletonMailer extends \Swift_Mailer
{
    /**
     * @var ManagerRegistryInterface
     */
    private $doctrine;
    
    /**
     * @var Email
     */
    private $senderConfig;
    
    /**
     * @var EmailTransport
     */
    private $transportConfig;
    
    public function __construct(ManagerRegistryInterface $doctrine, \Swift_SmtpTransport $transport) 
    {
        $this->doctrine     = $doctrine;
        
        $this->buildConfig();
        
        parent::__construct($this->buildTransport($transport));
    }
    
    private function buildConfig()
    {
        $this->senderConfig = $this->doctrine
            ->getRepository(Email::class)
            ->findOneBy([]);
        
        $this->transportConfig = $this->doctrine
            ->getRepository(EmailTransport::class)
            ->findOneBy([]);
    }
    
    public function getMessageWithSenderConfig() : \Swift_Message
    {
        return (new \Swift_Message())
            ->setFrom($this->senderConfig->getFromEmail())
            ->setTo($this->senderConfig->getToEmail())
            ->setReplyTo($this->senderConfig->getResponseEmail(), $this->senderConfig->getFromName())
        ;
    }

    private function buildTransport(\Swift_SmtpTransport $transport) : \Swift_SmtpTransport
    {
        return $transport
            ->setHost($this->transportConfig->getHost())
            ->setUsername($this->transportConfig->getUsername())
            ->setPassword($this->transportConfig->getPassword())
            ->setPort($this->transportConfig->getPort())
            ->setEncryption($this->transportConfig->getEncryption())
            ->setAuthMode($this->transportConfig->getAuthMode())
            ;
    }
    
    public function getSenderConfig() : Email
    {
        return $this->senderConfig;
    }
    
    public function getTransportConfig() : EmailTransport
    {
        return $this->transportConfig;
    }
}
