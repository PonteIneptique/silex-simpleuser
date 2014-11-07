<?php

	use Doctrine\ORM\Tools\Setup;
	use Doctrine\ORM\EntityManager;
	use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
	use Doctrine\Common\Annotations\AnnotationReader;

    $app['doctrine.orm.entity_manager'] = $app->share(function ($app) {
        $conn = $app['dbs']['default'];
        $em = $app['dbs.event_manager']['default'];


        $isDevMode = true;
        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__.'/../src/SimpleUser/Entity'), $isDevMode, null, null, false);
        $em = EntityManager::create($conn, $config, $em);
        return $em;
    });