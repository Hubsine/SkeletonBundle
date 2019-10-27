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
use Hubsine\SkeletonBundle\HubsineSkeletonBundleEvents;
use Hubsine\SkeletonBundle\Event\SkeletonVariableEvent;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

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
    private $excludeRoutes = ['fos_user_security_login', '_profiler', '_wdt'];

    public function __construct(ManagerRegistry $doctrine, TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $authorizationChecker,
        \Twig_Environment $twig, $env) 
    {
        $this->doctrine                 = $doctrine;
        $this->tokenStorage             = $tokenStorage;
        $this->authorizationChecker     = $authorizationChecker;
        $this->twig                     = $twig;
        $this->env                      = $env;
        
        // On récupère la premiere page de maintenance. 
        $this->maintenancePage          = $this->doctrine->getRepository(MaintenanceTranslation::class)->findOneBy([]);
    }
    
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest'],
            HubsineSkeletonBundleEvents::HUBSINE_SKELETON_VARIABLE  => 'addMaintenance'
        ];
    }
    
    public function onKernelRequest(GetResponseEvent $event)
    {
        if( $isMaintenance  = $this->isMaintenanceMode() === false || $this->isAdmin() )
        {
            return;
        }

        $routeName  = $this->getCurrentRouteName($event);
        
        if ( in_array( $routeName, $this->getExcludeRoutes() ) )
        {
            return;
        }        
        
        $response   = $event->hasResponse() ? $event->getResponse() : new Response() ;
        $view       = $this->getMaintenanceView();

        $response->setContent($view);
        $event->setResponse($response);
    }
    
    public function addMaintenance(SkeletonVariableEvent $event)
    {
        $skeletonVariable       = $event->getSkeletonVariable();
        
        $skeletonVariable->addVariable('maintenance', $this->maintenancePage);
    }

    /**
     * Check if is maintenance mode 
     * 
     * @return boolean
     */
    protected function isMaintenanceMode()
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
    protected function isAdmin()
    {
        // Important : la méthode isGranted return une exception AuthenticationCredentialsNotFoundException lors du chargement du prodil
        // Cela est du au fait qu'il n'existe pas de firewall pour le profil
        
        $user = $this->tokenStorage->getToken() === null ? null : $this->tokenStorage->getToken()->getUser();
        
        if( $user !== null && $this->authorizationChecker->isGranted('ROLE_ADMIN') )
        {
            return true;
        }
        
        return false;
    }

    /**
     * getExcludeRoutes
     * 
     * @return array Exclude roure
     */
    protected function getExcludeRoutes()
    {
        return $this->excludeRoutes;
    }
    
    /**
     * Render maintenance mode page view
     * @return string
     */
    protected function getMaintenanceView()
    {
        return $this->twig->render('@HubsineSkeleton/Base/maintenance.html.twig', [
            'page'  => $this->maintenancePage
        ]);
    }

    protected function getCurrentRouteName(GetResponseEvent $event)
    {
        return $event->getRequest()->attributes->get('_route');   
    }
}
