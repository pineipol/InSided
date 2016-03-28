<?php

// Include Composer Autoload (relative to project root).
require "../vendor/autoload.php";

// Define root dir
define('ROOT_DIR', dirname(dirname(__FILE__)) . '/');

// boostrap application components
require '../bootstrap.php';

// start application
\Application\Application::start(
    $_SERVER['REQUEST_METHOD'], 
    $_SERVER['REQUEST_URI'], 
    ('POST' === $_SERVER['REQUEST_METHOD'] ? $_POST : []),
    getallheaders()
);
