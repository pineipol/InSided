<?php

namespace InSided\ImageThread\Service;

use Application\Application;
use InSided\ImageThread\Entity\Post;
use InSided\ImageThread\Exception\FileUploadException;
use InSided\ImageThread\Form\PostForm;

/**
 * Handles post business logic
 */
class PostManager 
{
    /**
     * Returns all posts
     * 
     * @return \Doctrine\Common\Collections\Collection
     */
    public static function getAllPosts() 
    {
        $em = Application::getEntityManager();
        
        return $em->getRepository('InSided\ImageThread\Entity\Post')
                ->findBy([], ['id' => 'DESC']);
    }
    
    /**
     * Validates post form
     * 
     * @param array $postParams
     * @param array $superglobalFiles
     * 
     * @return array Errors
     */
    public static function validateForm(array $postParams, array $superglobalFiles)
    {
        return PostForm::validate([
            'post-title' => $postParams['post-title'],
            'post-image' => $superglobalFiles['post-image'],
        ]);
    }
    
    /**
     * Handles all operations related to file upload
     * 
     * @param array $file
     * @param \InSided\ImageThread\Service\FileManager $fileManager
     * @return string Uploaded filename
     * 
     * @throws FileUploadException If file excedes allowed size
     */
    public static function uploadFile(array $file, FileManager $fileManager)
    {
        $config = Application::getConfig();    
        
        // if file is biggerthan allowed exception is thrown
        if ($file['size'] >= $config['application']['maxFileSize']) {
            throw new FileUploadException('File size (20MB) exceeded!');
        }                
        
        // create unique filename
        $targetFileName = $fileManager->createUniqueFileName(ROOT_DIR . $config['application']['uploadsDir'], $file['name']);

        // move file to uploads dir
        $fileManager->moveFileToUploadsDir($file['tmp_name'], ROOT_DIR . $config['application']['uploadsDir'] . $targetFileName);

        // generate file thumb
        $thumbFileName = $fileManager->copyImageToThumb($targetFileName, ROOT_DIR . $config['application']['uploadsDir']);
        
        //Resizes the image to the max defaults dimensions
        $fileManager->resizeImage(
            $file['type'], 
            ROOT_DIR . $config['application']['uploadsDir'], 
            $targetFileName, 
            $config['application']['maxImageWidth'],
            $config['application']['maxImageHeight'],
            $config['application']['imageQuality']
        );
        
        //Resizes the thumb to the max thumbs dimensions
        $fileManager->resizeImage(
            $file['type'], 
            ROOT_DIR . $config['application']['uploadsDir'], 
            $thumbFileName,
            $config['application']['maxThumbWidth'],
            $config['application']['maxThumbHeight'],
            $config['application']['imageQuality']
        );
        
        return $config['application']['publicUploadsDir'] . $targetFileName;
    }    
    
    /**
     * Stores a new post record into the database
     * 
     * @param string $postTitle
     * @param string $postFilePath
     */
    public static function newPost($postTitle, $postFilePath)
    {
        $em = Application::getEntityManager();
        
        $newPost = new Post();
        $newPost->setTitle($postTitle);
        $newPost->setPath($postFilePath);
        $em->persist($newPost);
        $em->flush();
    }
    
    /**
     * Returns post total number 
     * 
     * @return integer
     */
    public static function getTotalPosts()
    {
        $em = Application::getEntityManager();
        
        return count($em
                ->getRepository('InSided\ImageThread\Entity\Post')
                ->findAll());
    }
}
