<?php

namespace Proglab\PrintSmarterApiClient;

use Proglab\PrintSmarterApiClient\Service\PrintSmarterApiClient;
use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

final class PrintSmarterApiClientBundle extends AbstractBundle implements PrependExtensionInterface
{
    public function prepend(ContainerBuilder $container): void
    {
        // Enregistre le répertoire templates/ du bundle sous @PrintSmarterApiClient
        $container->prependExtensionConfig('twig', [
            'paths' => [__DIR__ . '/../templates' => 'PrintSmarterApiClient'],
        ]);
    }

    public function configure(DefinitionConfigurator $definition): void
    {
        $definition->rootNode()
            ->children()
                ->scalarNode('apiKey')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('apiUrl')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('customerId')->isRequired()->cannotBeEmpty()->end()
            ->end()
        ;
    }

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import('../config/services.yaml');

        $builder->getDefinition(PrintSmarterApiClient::class)
            ->setArgument('$apiKey', $config['apiKey'])
            ->setArgument('$apiUrl', $config['apiUrl'])
            ->setArgument('$customerId', $config['customerId']);
    }
}
