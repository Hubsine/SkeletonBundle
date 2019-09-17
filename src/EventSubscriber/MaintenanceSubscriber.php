<?php

namespace Hubsine\SkeletonBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
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

    /**
     * @var array
     */
    private $exludeRoutes = ['fos_user_security_login'];

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
            KernelEvents::RESPONSE => 'onKernelRequest',
        ];
    }
    
    public function onKernelRequest(FilterResponseEvent $event)
    {
        $routeName      = $event->getRequest()->attributes->get('_route');
        $isMaintenance  = $this->isMaintenanceMode();
        
        $firewall = $event->getRequest()->attributes->get('_firewall_context');
        
        if( $isMaintenance && ! $this->isAdmin() 
            &&  $firewall === 'security.firewall.map.context.main' 
            && ! in_array($routeName, $this->exludeRoutes) )
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
    private function isAdmin()
    {
        $user = $this->tokenStorage->getToken() === null ? null : $this->tokenStorage->getToken()->getUser();
        
        if( $user instanceof \FOS\UserBundle\Model\UserInterface && ( $user->hasRole('ROLE_ADMIN') || $user->hasRole('ROLE_SUPER_ADMIN') ) )
        {
            return true;
        }
        
        return false;
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
