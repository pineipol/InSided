<?php

namespace InSided\ImageThread\Form;

/**
 * Forms base class
 * 
 * Includes validation features and setup the base for new forms
 */
abstract class BaseForm 
{
    /**
     * @var array Field constraints
     */
    protected static $constraints = [];
    
    /**
     * @var array Field errors
     */
    protected static $errors = [];

    /**
     * Executes callbacks for each field constraint to validate fields
     * 
     * @param string $constraintName Callback name
     * @param mixed $callbackArgs Arg to be passed to callback
     * @return array
     */
    protected static function validateConstraint($constraintName, $callbackArgs)
    {
        $errors = [];
        
        // validate every constraint for every field
        if (array_key_exists($constraintName, static::$constraints)) {
            foreach (static::$constraints[$constraintName] as $constraintCallback => $constraintResult) {
                $callbackResult = call_user_func($constraintCallback, $callbackArgs);
                if ($constraintResult !== $callbackResult) {
                    $errors[$constraintName] = static::$errors[$constraintName][$constraintCallback];
                }
            }
        } 
        
        // return erros if exists
        return $errors;
    }

    /**
     * Abstract method validate. All forms must implement it
     */
    abstract public static function validate(array $fields);
}
