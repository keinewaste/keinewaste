<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Bridge\ProxyManager\LazyProxy\PhpDumper\ProxyDumper as DiProxyDumper;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper as DiPhpDumper;
use Doctrine\Common\Proxy\Autoloader;
use Doctrine\DBAL\Types\Type;
use KeineWaste\Helpers\Types\UTCDateTimeType;

require_once __DIR__ . '/../vendor/autoload.php';
if (!defined('PROJECT_PATH')) {
    define('PROJECT_PATH', realpath(__DIR__ . '/../'));
}

Autoloader::register(__DIR__ . '/../src/Dto/Proxy', 'Instela\\Dto\\Proxy');
Type::overrideType('datetime', UTCDateTimeType::class);
Type::overrideType('datetimetz', UTCDateTimeType::class);

set_include_path(get_include_path() . PATH_SEPARATOR . PROJECT_PATH);

$diCacheFilename = __DIR__ . '/../cache/keinewaste.di.cache.php';

$debug = false;

if ($debug == true || !file_exists($diCacheFilename)) {
    $container = new ContainerBuilder();
    $loader    = new YamlFileLoader($container, new FileLocator(__DIR__));
    $loader->load(PROJECT_PATH . '/config/di.yaml');
    $container->compile();
    $proxyDumper = new DiProxyDumper();
    $diDumper    = new DiPhpDumper($container);
    $diDumper->setProxyDumper($proxyDumper);
    $diCache = $diDumper->dump(['class' => 'KeineWasteDependencyInjectionContainer', 'base_class' => '\\KeineWaste\\Di\\Base']);
    file_put_contents($diCacheFilename, $diCache);
}

/**
 * @noinspection PhpIncludeInspection
 */
require_once $diCacheFilename;

/**
 * @var $diContainer KeineWaste\Di\Base
 * @noinspection PhpUndefinedClassInspection
 */
return new KeineWasteDependencyInjectionContainer();