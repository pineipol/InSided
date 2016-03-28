<?php

namespace InSided\ImageThread\Tests\Service;

use InSided\ImageThread\Service\PostManager;
use PHPUnit_Framework_TestCase;

/**
 * Test sample to PostManagerTests
 * 
 * I decided to mock FileManager as if it was an external library to show 
 * some mocking into the tests
 */
class PostManagerTest extends PHPUnit_Framework_TestCase
{
    /**
     * Get all posts should return two posts
     */
    public function testGetAllPostsShouldReturnTwoPosts()
    {
        $this->assertCount(2, PostManager::getAllPosts());
    }
    
    /**
     * Validate valid form should return zero errors
     */
    public function testValidateValidFormShouldReturnZeroErrors()
    {
        $errors = PostManager::validateForm([
            'post-title' => 'Post title',
        ], [
            'post-image' => [
                'name' => 'file.jpg',
                'type' => 'image/jpeg',
                'tmp_name' => '/tmp/blablabla',
                'error' => 0,
                'size' => 1500,
            ]
        ]);
        $this->assertCount(0, $errors);        
    }
    
    /**
     * Validate invalid form should return one errors
     */
    public function testValidateInvalidFormShouldReturnOneErrors()
    {
        $errors = PostManager::validateForm([
            'post-title' => 'Post title',
        ], [
            'post-image' => [
                'name' => 'file.jpg',
                'type' => 'image/jpeg',
                'tmp_name' => '/tmp/blablabla',
                'error' => 4,
                'size' => 1500,
            ]
        ]);
        $this->assertCount(1, $errors);        
    }
    
    /**
     * Upload file should use file manager to upload files
     */
    public function testUploadFileShouldUseFileManagerToUploadFiles()
    {
        $fileManagerMock = $this->getFileManagerMock();
        PostManager::uploadFile([
            'name' => 'fileName.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => '/tmp/blablabla',
            'error' => 4,
            'size' => 1500,
        ], $fileManagerMock);
    }
    
    /**
     * Upload too big file should throw exception
     * 
     * @expectedException InSided\ImageThread\Exception\FileUploadException
     */
    public function testUploadTooBigFileShouldThrowException()
    {
        PostManager::uploadFile([
            'name' => 'fileName.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => '/tmp/blablabla',
            'error' => 4,
            'size' => 99999999,
        ], new \InSided\ImageThread\Service\FileManager());
    }

    /**
     * New post method should create a new post
     */
    public function testNewPostMethodShouldCreateANewPost()
    {
        $this->assertCount(2, PostManager::getAllPosts());
        
        PostManager::newPost('New post', ROOT_DIR . 'web/uploads/fileName.jpg');
        
        $this->assertCount(3, PostManager::getAllPosts());
    }
    
    /**
     * Get total post should return posts quantity
     */
    public function testGetTotalPostShouldReturnPostsQuantity()
    {
        $this->assertEquals(3, PostManager::getTotalPosts());
    }
    
    /**
     * Generates a mock object for FileManager to be injected 
     * into PostManager::uploadFile test
     */
    public function getFileManagerMock()
    {
        $fileManagerMock = $this->getMockBuilder('InSided\ImageThread\Service\FileManager')
                         ->setMethods([
                             'createUniqueFileName', 
                             'moveFileToUploadsDir',
                             'copyImageToThumb',
                             'resizeImage',
                         ])
                         ->getMock();
        
        $fileManagerMock->expects($this->once())
                 ->method('createUniqueFileName')
                 ->with($this->equalTo(ROOT_DIR . 'web/uploads/'),
                         $this->equalTo('fileName.jpg'))
                ->willReturn('fileName.jpg');
        
        $fileManagerMock->expects($this->once())
                 ->method('moveFileToUploadsDir')
                 ->with($this->equalTo('/tmp/blablabla'), 
                         $this->equalTo(ROOT_DIR . 'web/uploads/fileName.jpg'));
        
        $fileManagerMock->expects($this->once())
                 ->method('copyImageToThumb')
                 ->with($this->equalTo('fileName.jpg'), 
                         $this->equalTo(ROOT_DIR . 'web/uploads/'));
        
        $fileManagerMock->expects($this->exactly(2))
                 ->method('resizeImage')
                 ->with($this->logicalOr(
                     'image/jpeg', 
                     ROOT_DIR . 'web/uploads/',
                     'fileName.jpg',
                     1920,
                     1080,
                     95,
                     'thumb_fileName.jpg',
                     400,
                     225
                ));
        
        return $fileManagerMock;
    }
}
