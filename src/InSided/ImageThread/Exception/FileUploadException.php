<?php

namespace InSided\ImageThread\Exception;

/**
 * File upload exception
 */
class FileUploadException extends \Exception
{
    /**
     * Class constructor
     * 
     * @param string $message
     * @param int  $code
     * @param \Exception $previous
     */
    public function __construct($message = "", $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
