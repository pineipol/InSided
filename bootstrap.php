<?php

use \Application\Application;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

// Load config from ini file
$config = parse_ini_file(ROOT_DIR . 'app/config/config.ini', true);
Application::setConfig($config);

// Doctrine entity autoload setup
$paths = [ROOT_DIR . "src/InSided/ImageThread/Entity"];
$isDevMode = false;

$dbParams = [
    'driver' => $config['dbconfigs']['driver'],
    'user' => $config['dbconfigs']['user'],
    'password' => $config['dbconfigs']['password'],
    'dbname' => $config['dbconfigs']['dbname'],
];
$dbConfig = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
Application::setEntityManager(EntityManager::create($dbParams, $dbConfig));
