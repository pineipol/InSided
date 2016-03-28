<?php

namespace InSided\ImageThread\Controller;

use Application\Application;
use Exception;
use InSided\ImageThread\Helper\FlashMessenger;
use InSided\ImageThread\Service\ApplicationManager;
use InSided\ImageThread\Service\FileManager;
use InSided\ImageThread\Service\PostManager;

/**
 * Controller that manages post related actions
 */
class PostController
{
    /**
     * Defaul Action.
     * Shows all posts ordered by ID descending
     * 
     * @param array $params Front controller passes request parameteres
     */
    public function defaultAction(array $params = null) 
    {
        // get application config
        $config = Application::getConfig();
        
        // Adds one view to the database
        ApplicationManager::addViews();
        
        // get post collection to make it available to the template
        $postCollection = PostManager::getAllPosts();
        require_once ROOT_DIR . $config['application']['viewsDir'] . 'posts/post-list.php';
    }
    
    /**
     * Handles post creation and file upload
     * 
     * @param array $params Front controller passes request parameteres
     */
    public function uploadAction(array $params = null) 
    {
        try {
            // if post method
            if ('POST' == $_SERVER['REQUEST_METHOD']) {
                
                // validate form 
                $validationErrors = PostManager::validateForm($_POST, $_FILES);
                
                // if valid form
                if (empty($validationErrors)) {
                    
                    // upload file
                    $newFilePath = PostManager::uploadFile($_FILES['post-image'], new FileManager());
                    
                    // save new post to database
                    PostManager::newPost($_POST['post-title'], $newFilePath);
                    
                    // redirect to defaulAction to show post List
                    FlashMessenger::setMessage('New post correctly added!');
                } else {
                    // show error messages
                    FlashMessenger::setMessage(implode('; ', $validationErrors));
                }
            } else {
                // show error messages
                FlashMessenger::setMessage('Error. Invalid get method!');
            }
        } catch (Exception $e) {
            // show exception message
            FlashMessenger::setMessage($e->getMessage());
        } finally {
            // always redirect to post list
            $this->defaultAction();
        }        
    }
}
