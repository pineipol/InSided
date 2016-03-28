<?php

namespace InSided\ImageThread\Service;

use Application\Application;

/**
 * This class is related to miscelaneous application features
 */
class ApplicationManager
{
    /**
     * Add one to views database counter
     */
    public static function addViews()
    {
        $em = Application::getEntityManager();
     
        // get current value
        $views = $em->getRepository('InSided\ImageThread\Entity\Option')
                ->findOneBy(['key' => 'views']);
        
        // store it on database
        $totalViews = intval($views->getValue(), 10);
        $views->setValue(++$totalViews);
        $em->persist($views);
        $em->flush();
    }
    
    /**
     * Returns total views quantity
     * 
     * @return string
     */
    public static function getTotalViews()
    {
        $em = Application::getEntityManager();
        
        $views = $em->getRepository('InSided\ImageThread\Entity\Option')
                ->findOneBy(['key' => 'views']);
        
        return $views->getValue();
    }
}
