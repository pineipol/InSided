<?php

namespace Application;

use Doctrine\ORM\EntityManager;

/**
 * Application class.
 * 
 * Container to handle services to be used globally and start application flow
 */
class Application 
{
    /**
     *
     * @var EntityManager $em Doctrine EntityManager
     */
    protected static $em = null;
    
    /**
     *
     * @var array $config Application configuration
     */
    protected static $config = null;
    
    /**
     * Sets Application config
     * 
     * @param array $config Application config
     */
    public static function setConfig(array $config)
    {
        self::$config = $config;
    }

    /**
     * Returns application config
     * 
     * @return array Application config
     */
    public static function getConfig()
    {
        return self::$config;
    }
    
    /**
     * Sets Doctrine EntityManager
     * 
     * @param EntityManager $em Doctrine EntityManager
     */
    public static function setEntityManager(EntityManager $em)
    {
        self::$em = $em;
    }

    /**
     * Returns Doctrine EntityManager
     * 
     * @return EntityManager Doctrine EntityManager
     */
    public static function getEntityManager()
    {
        return self::$em;
    }
    
    /**
     * Start application flow 
     * 
     * @param string $requestMethod HTTP method
     * @param string $requestUri Request query string
     * @param array $postParams If post request, post params
     * @param array $headers Request headers
     */
    public static function start($requestMethod, $requestUri, array $postParams, array $headers)
    {
        FrontController::render($requestMethod, $requestUri, $postParams, $headers);
    }
}
