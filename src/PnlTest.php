<?php

namespace Pnl\PnlTest;

use Pnl\Extensions\AbstractExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class PnlTest extends AbstractExtension
{
    public static string $name = 'pnltest';

    public function getCommandTag(): string
    {
        return 'pnltest-command';
    }

    public function prepareContainer(ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../config'));
        $loader->load('services.yaml');
    }
}
