<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// project bootstrap
require_once 'bootstrap.php';

// replace with mechanism to retrieve EntityManager in your app
return ConsoleRunner::createHelperSet($GLOBALS['entityManager']);