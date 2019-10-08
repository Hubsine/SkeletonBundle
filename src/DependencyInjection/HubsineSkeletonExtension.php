<?php
namespace Hubsine\SkeletonBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Hubsine\SkeletonBundle\DependencyInjection\Configuration;

/**
 * HubsineSkeletonExtension
 *
 * @author Hubsine <contact@hubsine.com>
 */
class HubsineSkeletonExtension extends Extension
{
    /**
     * Get Yaml Loader
     * 
     * @param ContainerBuilder $container
     * @return YamlFileLoader
     */
    private function getLoader(ContainerBuilder $container)
    {
        return new YamlFileLoader(
            $container, 
            new FileLocator( __DIR__ . '/../Resources/config' ) 
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        return new Configuration();
    }
    
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = $this->getLoader($container);
        
        $loader->load('services.yaml');
    }
    
}
