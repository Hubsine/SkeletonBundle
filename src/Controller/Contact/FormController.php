<?php

namespace Hubsine\SkeletonBundle\Controller\Contact;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Hubsine\SkeletonBundle\Entity\Contact\Form;
use Hubsine\SkeletonBundle\Form\Contact\FormType;
use Hubsine\SkeletonBundle\Entity\Setting\Email;

class FormController extends Controller
{
    /**
     */
    public function indexAction(Request $request)
    {
        $formEntity = new Form();
        $form       = $this->createForm(FormType::class, $formEntity);
        
        
        $form->handleRequest($request);
        
        if( $form->isSubmitted() && $form->isValid() )
        {
            $emailConfig = $this->getDoctrine()
                    ->getRepository(Email::class)
                    ->findOneBy([]);
            
            if( $emailConfig instanceof Email )
            {
                $mailer = new \Swift_Mailer( $this->getTransport($emailConfig) );
                $mailer->send( $this->getMessage($formEntity, $emailConfig) );
            }
        }
        
        return $this->render('@HubsineSkeleton/contact/index.html.twig', [
            'form'  => $form->createView()
        ]);
    }
    
    private function getMessage(Form $formEntity, Email $emailConfig)
    {
        return $message = (new \Swift_Message())
            ->setFrom($emailConfig->getFromEmail())
            ->setTo($formEntity->getEmail())
            ->setSubject('Message from Ethno Tendance')    
            ->setReplyTo($formEntity->getEmail(), $formEntity->getFirstName() . ' ' . $formEntity->getLastName() )
            ->setBody(
                $this->renderView(
                    '@HubsineSkeleton/contact/message.html.twig',
                    ['message' => $formEntity]
                ),
                'text/html'
            )
        ;
    }
    
    private function getTransport(Email $emailConfig)
    {
        return $transport = ( new \Swift_SmtpTransport())
                ->setHost($emailConfig->getHost())
                ->setUsername($emailConfig->getUsername())
                ->setPassword($emailConfig->getPassword())
                ->setPort($emailConfig->getPort())
                ->setEncryption($emailConfig->getEncryption())
                ->setAuthMode($emailConfig->getAuthMode())
                ;
    }
}
