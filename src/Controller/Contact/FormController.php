<?php

namespace Hubsine\SkeletonBundle\Controller\Contact;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Hubsine\SkeletonBundle\Entity\Contact\Form;
use Hubsine\SkeletonBundle\Form\Contact\FormType;

class FormController extends Controller
{
    /**
     */
    public function index(Request $request)
    {
        $formEntity = new Form();
        $form       = $this->createForm(FormType::class, $formEntity);
        
        
        $form->handleRequest($request);
        
        if( $form->isSubmitted() && $form->isValid() )
        {
            $mailer = $this->get('mailer');
        }
        
        return $this->render('@HubsineSkeleton/contact/index.html.twig', [
            'form'  => $form->createView()
        ]);
    }
}
