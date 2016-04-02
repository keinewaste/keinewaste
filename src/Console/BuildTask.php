<?php


namespace KeineWaste\Console;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Bridge\ProxyManager\LazyProxy\PhpDumper\ProxyDumper as DiProxyDumper;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper as DiPhpDumper;

class BuildTask extends Command
{


    protected function configure()
    {
        $this
            ->setName('build-di')
            ->setDescription('Build DI Cache');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->buildDiCache($input, $output);
    }


    protected function buildDiCache(InputInterface $input, OutputInterface $output)
    {
        $output->write('building...');

        $diCacheFilename = __DIR__ . '/../../cache/keinewaste.di.cache.php';

        $container = new ContainerBuilder();
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__));
        $loader->load(__DIR__ . '/../../config/di.yaml');
        $container->compile();
        $proxyDumper = new DiProxyDumper();
        $diDumper    = new DiPhpDumper($container);
        $diDumper->setProxyDumper($proxyDumper);
        $diCache = $diDumper->dump(['class' => 'KeineWasteDependencyInjectionContainer', 'base_class' => '\\KeineWaste\\Di\\Base']);
        file_put_contents($diCacheFilename, $diCache);
    }
}