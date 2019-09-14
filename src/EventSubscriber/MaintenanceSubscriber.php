<?php

namespace Hubsine\SkeletonBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Doctrine\Common\Persistence\ManagerRegistry;
use Hubsine\SkeletonBundle\Entity\Setting\MaintenanceTranslation;

class MaintenanceSubscriber implements EventSubscriberInterface
{
    /**
     * @var doctrine
     */
    private $doctrine;
    
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;
    
    /**
     * @var TwigInterface $twig
     */
    private $twig;
    
    /**
     * @var string
     */
    private $env;

    /**
     * Maintenance Doctrine Entity
     * 
     * @var MaintenanceTranslation
     */
    private $maintenancePage;
    
    public function __construct(ManagerRegistry $doctrine, TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $authorizationChecker,
        \Twig_Environment $twig, $env) 
    {
        $this->doctrine                 = $doctrine;
        $this->tokenStorage             = $tokenStorage;
        $this->authorizationChecker     = $authorizationChecker;
        $this->twig                     = $twig;
        $this->env                      = $env;
        
        // On récupère la premiere page de maintenance. 
        $this->maintenancePage          = $this->doctrine->getRepository(MaintenanceTranslation::class)->findOneByEnabled(true);
    }
    
    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }
    
    public function onKernelRequest(GetResponseEvent $event)
    {
        $routeName      = $event->getRequest()->attributes->get('_route');
        $isMaintenance  = $this->isMaintenanceMode();
        
        if( $isMaintenance && $this->isSuperAdmin() && $routeName !== 'fos_user_security_login' )
        {
        
            $response = $event->getResponse() === null ? new Response() : $event->getResponse();

            $view = $this->getMaintenanceView();

            $response->setContent($view);
            $event->setResponse($response);
        }
    }
    
    /**
     * Check if is maintenance mode 
     * 
     * @return boolean
     */
    private function isMaintenanceMode()
    {
        return $this->maintenancePage instanceof MaintenanceTranslation ? 
                $this->maintenancePage
                ->getTranslatable()
                ->getEnable() : false;
    }

    /**
     * Check if is maintenance Mode 
     * 
     * @return boolean
     */
    private function isSuperAdmin()
    {
        return $this->authorizationChecker->isGranted('ROLE_ADMIN');
    }
    
    /**
     * Render maintenance mode page view
     * @return string
     */
    private function getMaintenanceView()
    {
        return $this->twig->render('@HubsineSkeleton/Base/maintenance.html.twig', [
            'page'  => $this->maintenancePage
        ]);
    }
}
