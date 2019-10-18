<?php

namespace Hubsine\SkeletonBundle\Tests\Mailer;

use Hubsine\SkeletonBundle\Test\AbstractWebTestCase;
use Hubsine\SkeletonBundle\Entity\Setting\Email;
use Hubsine\SkeletonBundle\Entity\Setting\EmailTransport;

/**
 * SkeletonMailer
 *
 * @author Hubsine <contact@hubsine.com>
 */
class SkeletonMailer extends AbstractWebTestCase
{
    public function testSendEmail()
    {
        $client = static::createClient();
        $mailer = $client->getContainer()->get('swiftmailer.mailer.skeleton');
        
        $this->assertInstanceOf(Email::class, $mailer->getSenderConfig());
        $this->assertInstanceOf(EmailTransport::class, $mailer->getTransportConfig());
        
    }
}
