<?php

namespace InSided\ImageThread\Service;

/**
 * Handles file upload logic.
 * For each image move to uploads folder, resizes it and create a thumbnail
 */
class FileManager
{
    /**
     * @var arrya Image accepted formats and callbacks to be used for every one of them
     */
    protected $acceptedImageFormats = [
        'image/gif' => [
            'createCallback' => 'imagecreatefromgif',
            'saveCallback' => 'imagegif',
        ],
        'image/jpeg' => [
            'createCallback' => 'imagecreatefromjpeg',
            'saveCallback' => 'imagejpeg',
        ],
        'image/png' => [
            'createCallback' => 'imagecreatefrompng',
            'saveCallback' => 'imagepng',
        ],
        'image/bmp' => [
            'createCallback' => 'imagecreatefromwbmp',
            'saveCallback' => 'imagewbmp',
        ],
    ];

    /**    
     * If image is bigger then supported returns max permitted dimensions 
     * saving image ratio
     * 
     * @param int $imageWidth
     * @param int $imageHeight
     * @param int $maxWidth
     * @param int $maxHeight
     * @return array [width, height]
     */
    private function getMaxProportionalDimensions($imageWidth, $imageHeight, $maxWidth, $maxHeight) {

        if ($imageWidth > $maxWidth || $imageHeight > $maxHeight) {
            $ratio = $imageWidth / $imageHeight;
            if (($maxWidth / $ratio) <= $maxHeight) {
                $imageWidth = $maxWidth;
                $imageHeight = intval($maxWidth / $ratio, 10);
            } else {
                $imageWidth = intval($maxHeight * $ratio, 10);
                $imageHeight = $maxHeight;
            }
        }
        return [$imageWidth, $imageHeight];
    }
    
    /**
     * Returns a unique file name to avoid file overwrote
     * 
     * @param string $path Path wher to store file
     * @param string $originalFileName Original file name
     * @return string Target file name
     */
    public function createUniqueFileName($path, $originalFileName) 
    {
        $fileBasename = pathinfo($originalFileName, PATHINFO_FILENAME);
        $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
                
        $index = 0;
        while (file_exists($path . $fileBasename . ($index ? "($index)." : '.') . $fileExtension)) {
            $index++;
        }
        return $fileBasename . ($index ? "($index)." : '.') . $fileExtension;
    }
    
    /**
     * Moves uploaded file from tmp folder to uploads dir
     * 
     * @param string $tmpFileName Tmp file name
     * @param string $targetFileName Target file name
     */
    public function moveFileToUploadsDir($tmpFileName, $targetFileName)
    {
        //Sets the file in its destination folder
        if (is_uploaded_file($tmpFileName)) {
            move_uploaded_file($tmpFileName, $targetFileName);
            chmod($targetFileName, 0777);
        }
    }

    /**
     * Copy uploade image to a new file to shrink it to create a thumb
     * 
     * @param string $fileName
     * @param string $uploadsDir
     * @return string Thumb filename
     */
    public function copyImageToThumb($fileName, $uploadsDir)
    {
        $thumbFileName = 'thumb_' . $fileName;
        copy($uploadsDir . $fileName, $uploadsDir . $thumbFileName);
        chmod($uploadsDir . $thumbFileName, 0777);
        
        return $thumbFileName;
    } 
    
    /**
     * Resizes file to specified parameters
     * 
     * @param string $fileType File type to select conversion callback
     * @param string $uploadsDir
     * @param string $fileName
     * @param string $maxWidth
     * @param string $maxHeight
     * @param int $imageQuality Image quality to shrink image
     */
    public function resizeImage($fileType, $uploadsDir, $fileName, $maxWidth, $maxHeight, $imageQuality)
    {
        $acceptedImageFormats = $this->acceptedImageFormats;
        if (array_key_exists($fileType, $acceptedImageFormats)) {
            $imageHandle = $acceptedImageFormats[$fileType]['createCallback']($uploadsDir . $fileName);
            
            list($imageWidth, $imageHeight) = $this->getMaxProportionalDimensions(imagesx($imageHandle), imagesy($imageHandle), $maxWidth, $maxHeight);
            
            //Creates a new image
            $newImageHandle = imagecreatetruecolor($imageWidth, $imageHeight);
            
            //Resizes source image to new_image
            imagecopyresized($newImageHandle, $imageHandle, 0, 0, 0, 0, $imageWidth, $imageHeight, imagesx($imageHandle), imagesy($imageHandle));
            
            //Saves the resized image with $dst_img name
            if ('image/jpeg' == $fileType) {
                $acceptedImageFormats[$fileType]['saveCallback']($newImageHandle, $uploadsDir . $fileName, $imageQuality);
            } else {
                $acceptedImageFormats[$fileType]['saveCallback']($newImageHandle, $uploadsDir . $fileName);
            }
        }
    }
}
