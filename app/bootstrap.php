<?php

/**
 * @author Thibault Clérice
 *
 *	The role of this page is to provide an environment for creating the DB in a test environment.
 *
 */
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

function create_app() {
	//phpunit_bootstrap.php
	$app = new \Silex\Application();

	$app->register(new \Silex\Provider\SecurityServiceProvider(),
		array('security.firewalls' => array('dummy-firewall' => array('form' => array())))
	);

	$app->register(new \Silex\Provider\DoctrineServiceProvider());

	$app['db.options'] = array(
	    'driver' => 'pdo_sqlite',
	    'path' => __DIR__.'/../cache/.ht.sqlite',
	);

	$app['user.model'] = array(
	    "user" => "\\SimpleUser\\Entity\\User"
	);

    $app['doctrine.orm.entity_manager'] = $app->share(function ($app) {
        $conn = $app['dbs']['default'];
        $em = $app['dbs.event_manager']['default'];


        $isDevMode = true;
        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__.'/../src/SimpleUser/Entity'), $isDevMode, null, null, false);
        $em = EntityManager::create($conn, $config, $em);
        return $em;
    });


	$app->boot();
	return $app;
}

/**
 * Inspired by authbucket/oauth2-php package's test suite.
 *
 */

function drop(Application $app) {
	$connection = $app["db"];
	$params = $connection->getParams();
	if (isset($params['master'])) {
	    $params = $params['master'];
	}
	$name = isset($params['path']) ? $params['path'] : (isset($params['dbname']) ? $params['dbname'] : false);
	unset($params['dbname']);
    if (!isset($params['path'])) {
        $name = $connection->getDatabasePlatform()->quoteSingleIdentifier($name);
    }
    $connection->getSchemaManager()->dropDatabase($name);
}

function create(Application $app) {
	$connection = $app["db"];
	$params = $connection->getParams();
	if (isset($params['master'])) {
	    $params = $params['master'];
	}
	$name = isset($params['path']) ? $params['path'] : (isset($params['dbname']) ? $params['dbname'] : false);
	unset($params['dbname']);

	$tmpConnection = DriverManager::getConnection($params); 
	$tmpConnection->getSchemaManager()->createDatabase($name);
}

function create_entity(Application $app) {
	$em = $app['doctrine.orm.entity_manager'];

	// Generate testing database schema.
	$classes = array();
	foreach ($app['user.model'] as $class) {
	    $classes[] = $em->getClassMetadata($class);
	}

	PersistentObject::setObjectManager($em);
	$tool = new SchemaTool($em);
	$tool->createSchema($classes);
}

function drop_entity($app) {
	$em = $app['doctrine.orm.entity_manager'];

	// Generate testing database schema.
	$classes = array();
	foreach ($app['user.model'] as $class) {
	    $classes[] = $em->getClassMetadata($class);
	}

	PersistentObject::setObjectManager($em);
	$tool = new SchemaTool($em);
	$tool->dropSchema($classes);
}

function getTableName($app) {
	$classes = array();

	foreach ($app['user.model'] as $class) {
	    $classes[] = $em->getClassMetadata($class)->getTableName();
	}

	return $classes;
}

function ifExistsThen($app, $fn) {
	$app["db"]->getSchemaManager();
	if ($schemaManager->tablesExist(getTableName($app))) {
		$fn($app);
	}
}

try {
	$app = create_app();
	drop($app);
} catch (Exception $e) {
	print_r($e);
}

try {
	$app = create_app();
	drop_entity($app);
} catch (Exception $e) {
	print_r($e);
}

try {
	$app = create_app();
	create($app);
} catch (Exception $e) {
	print_r($e);
}

try {
	$app = create_app();
	create_entity($app);
} catch (Exception $e) {
	print_r($e);
}

return create_app();
