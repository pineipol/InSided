<?php

namespace InSided\ImageThread\Form;

/**
 * Post form.
 * This class helps to validate forms
 */
class PostForm extends BaseForm
{
    /**
     * @var array Field constraints
     */
    protected static $constraints = [
        'post-image' => [
            'InSided\ImageThread\Form\PostForm::customFileValidation' => false,
        ],
    ];
    
    /**
     * @var array Field errors
     */
    protected static $errors = [
        'post-image' => [
            'InSided\ImageThread\Form\PostForm::customFileValidation' => 'Post image is required',
        ],
    ];

    /**
     * Validates all form fields
     * 
     * @param array $fields Fields to be validated
     * @return array Errors
     */
    public static function validate(array $fields) 
    {
        $errors = [];

        foreach ($fields as $fieldKey => $fieldValue) {
            $errors = array_merge($errors, static::validateConstraint($fieldKey, $fieldValue));            
        }
        
        return $errors;
    }
    
    /**
     * Custom constraint to validate file upload
     * 
     * @param array $superglobalFiles
     * @return boolean Validation result
     */
    public static function customFileValidation(array $superglobalFiles)
    {
        return empty($superglobalFiles) || 0 !== $superglobalFiles['error'];
    }
}
