<?php

require_once __DIR__ . "/../vendor/autoload.php";

use SimpleUser\UserServiceProvider;
use Silex\Application;
use Silex\Provider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Doctrine\ORM\Tools\SchemaTool;

//phpunit_bootstrap.php
$app = new \Silex\Application();

$app->register(new \Silex\Provider\SecurityServiceProvider(),
    array('security.firewalls' => array('dummy-firewall' => array('form' => array())))
);
$app->register(new \Silex\Provider\DoctrineServiceProvider());

$app['db'] = array( 
    'driver' => 'pdo_sqlite',
    'path' => __DIR__.'/../../../cache/test/.ht.sqlite',
);

$app->register(new UserServiceProvider());

/*
 * Setup the Schema
 */

$cacheDriver = new \Doctrine\Common\Cache\ArrayCache();
$deleted = $cacheDriver->deleteAll();

$em = $app["user.doctrine.em"];
$tool = new \Doctrine\ORM\Tools\SchemaTool($em);
$classes = array(
    $em->getClassMetadata('\\SimpleUser\\Entity\\User'),
    $em->getClassMetadata('\\SimpleUser\\Entity\\CustomeFields'),
);
$tool->createSchema($classes);