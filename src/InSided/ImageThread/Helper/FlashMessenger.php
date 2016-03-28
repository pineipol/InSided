<?php

namespace InSided\ImageThread\Helper;

/**
 * Helper that stores "one request" messages
 */
class FlashMessenger 
{
    /**
     *
     * @var string message
     */
    protected static $message = '';
    
    /**
     * Sets message
     * 
     * @param string $message
     */
    public static function setMessage($message)
    {
        self::$message = $message;
    }
    
    /**
     * Returns message
     * 
     * @return string
     */
    public static function getMessage()
    {
        $message = self::$message;
        self::$message = '';
        
        return $message;
    }
    
    /**
     * Retruns true if no messages stored 
     * 
     * @return boolean
     */
    public static function isEmpty()
    {
        return self::$message == '';
    }
}
