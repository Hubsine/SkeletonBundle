<?php

namespace Hubsine\SkeletonBundle\Controller\Contact;

use Hubsine\SkeletonBundle\Test\AbstractWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class FormControllerTest extends AbstractWebTestCase
{
    public function testMailIsSentAndContentIsOk()
    {
        $client = static::createClient([], [
            'HTTP_HOST'       => 'hubsine-skeleton.local'
        ]);

        $formData = [
            'form[email]'       => 'test@test.com',
            'form[firstName]'   => 'Foo',
            'form[lastName]'    => 'Bar',
            'form[subject]'     => 'Subject Foo',
            'form[message]'     => 'My Message'
        ];
        
        
        $crawler            = $client->request('GET', '/contact');
        
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        
        $buttonCrawlerNode  = $crawler->selectButton('form[submit]'); #select by id
        $form               = $buttonCrawlerNode->form($formData);

        $client->enableProfiler(); # Enable profiler for this request
        $client->submit($form, [], ['HTTPS' => "on"]);
        
        $this->assertEquals(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());
        $this->assertNotNull($client->getResponse()); 
        $this->assertNotNull($client->getProfile()); # Must have profiler for test sending email

        if( $client->getProfile() )
        {
            $mailCollector = $client->getProfile()->getCollector('swiftmailer');

            // checks that an email was sent
            $this->assertSame(1, $mailCollector->getMessageCount('skeleton'));

//            $collectedMessages = $mailCollector->getMessages('skeleton');
//            $message = $collectedMessages[0];
//
//            // Asserting email data
//            $this->assertInstanceOf('Swift_Message', $message);
//            $this->assertSame('Hello Email', $message->getSubject());
//            $this->assertSame('send@example.com', key($message->getFrom()));
//            $this->assertSame('recipient@example.com', key($message->getTo()));
//            $this->assertSame(
//                'You should see me from the profiler!',
//                $message->getBody()
//            );
        }
    }
}
