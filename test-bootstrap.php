<?php

use Application\Application;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use InSided\ImageThread\Tests\Fixtures\PostFixtureLoader;

// Include Composer Autoload (relative to project root).
require "./vendor/autoload.php";

define('ROOT_DIR', dirname(__FILE__) . '/');

// Load config from ini file
$config = parse_ini_file(ROOT_DIR . 'app/config/config.ini', true);
Application::setConfig($config);

// Doctrine entity autoload setup
$paths = [ROOT_DIR . "src/InSided/ImageThread/Entity"];
$isDevMode = false;

$dbParams = [
    'driver' => $config['test-dbconfigs']['driver'],
    'dbname' => $config['test-dbconfigs']['dbname'],
];
$dbConfig = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$em = EntityManager::create($dbParams, $dbConfig);
Application::setEntityManager($em);

// Doctrine testing setup
$schemaTool = new Doctrine\ORM\Tools\SchemaTool($em);
$metadata = $em->getMetadataFactory()->getAllMetadata();

$schemaTool->createSchema($metadata);
        
$purger = new ORMPurger();
$executor = new ORMExecutor(Application::getEntityManager(), $purger);

// Fixture loader
$loader = new Loader();
$loader->addFixture(new PostFixtureLoader());
$executor->execute($loader->getFixtures());
