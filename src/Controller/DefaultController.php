<?php

namespace Hubsine\SkeletonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @author Hubsine <contact@hubsine.com>
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('Base/front.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
