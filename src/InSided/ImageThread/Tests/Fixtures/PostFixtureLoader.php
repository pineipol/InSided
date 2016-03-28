<?php

namespace InSided\ImageThread\Tests\Fixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use InSided\ImageThread\Entity\Post;

/**
 * Fixtures to PostManagerTest
 */
class PostFixtureLoader implements FixtureInterface
{
    /**
     * @param ObjectManager $em Doctrine EntityManager
     */
    public function load(ObjectManager $em) 
    {        
        $postOne = new Post();
        $postOne->setTitle('Post one title');
        $postOne->setPath('Post one path');
        
        $postTwo = new Post();
        $postTwo->setTitle('Post two title');
        $postTwo->setPath('Post two path');

        $em->persist($postOne);
        $em->persist($postTwo);
        $em->flush();
    }
}
