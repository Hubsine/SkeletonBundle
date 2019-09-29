<?php

namespace Hubsine\SkeletonBundle\Controller\Contact;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Hubsine\SkeletonBundle\Entity\Contact\Form;
use Hubsine\SkeletonBundle\Form\Contact\FormType;
use Hubsine\SkeletonBundle\Entity\Content\Page;

class FormController extends Controller
{
    public function indexAction(Request $request)
    {
        $page = $this->getDoctrine()
                ->getRepository(Page::class)
                ->findOneByTag('contact');
        
        $formEntity = new Form();
        $form       = $this->createForm(FormType::class, $formEntity);
        
        $form->handleRequest($request);
       
        if( $form->isSubmitted() && $form->isValid() )
        {
            $mailer     = $this->get('swiftmailer.mailer.skeleton');
            $message    = $mailer->getMessageWithSenderConfig();
            
            $message->setReplyTo( $formEntity->getEmail(), $formEntity->getFirstName() . ' ' . $formEntity->getLastName() )
                    ->setSubject($formEntity->getSubject())
                    ->setBody(
                        $this->renderView(
                            '@HubsineSkeleton/contact/message.html.twig',
                            ['message' => $formEntity]
                        ),
                        'text/html'
                    );
            
            $send = $mailer->send( $message );
            
            if(  $send === 0 )
            {
                $this->addFlash('dander', 'Your message can not be sent.');
            }else{
                $this->addFlash('success', 'Your message is sent.');
            }
            
            return $this->redirectToRoute('page_contact');
        }
        
        return $this->render('@HubsineSkeleton/contact/index.html.twig', [
            'form'  => $form->createView(),
            'page'  => $page
        ]);
    }
}
