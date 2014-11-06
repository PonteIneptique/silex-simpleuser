<?php

require_once __DIR__ . "/../vendor/autoload.php";

use SimpleUser\UserServiceProvider;
use Silex\Application;
use Silex\Provider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\SecurityServiceProvider;

use Doctrine\DBAL\DriverManager;

use Doctrine\Common\Persistence\PersistentObject;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Cache\FilesystemCache;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Tools\SchemaTool;

use Symfony\Component\Filesystem\Filesystem;
use Doctrine\Common\Annotations\AnnotationRegistry;  

AnnotationRegistry::registerFile(__DIR__ . "/../vendor/doctrine/common/lib/Doctrine/Common/Persistence/Mapping/Driver/AnnotationDriver.php");

//phpunit_bootstrap.php
$app = new \Silex\Application();

$app->register(new \Silex\Provider\SecurityServiceProvider(),
	array('security.firewalls' => array('dummy-firewall' => array('form' => array())))
);

$app->register(new \Silex\Provider\DoctrineServiceProvider());

$app['db.options'] = array(
    'driver' => 'pdo_sqlite',
    'path' => __DIR__.'/cache/.ht.sqlite',
);

$app['user.model'] = array(
    "user" => "\\SimpleUser\\Entity\\User"
);

require_once __DIR__ . "/entity_manager.php";

$UserServiceProvider = new \SimpleUser\UserServiceProvider();
$app->register($UserServiceProvider);

$app->boot();

return $app;