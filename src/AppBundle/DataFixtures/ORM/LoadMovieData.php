<?php

namespace AppBundle\Controller;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Movie;

class LoadMovieData implements FixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     *
     */
    public function load(ObjectManager $manager)
    {
        $harry = new Movie('Harry Potter et la chambre des secrets');
        $fast = new Movie('Fast and Furious 8');
        $taken = new Movie('Taken 3');

        $manager->persist($harry);
        $manager->persist($fast);
        $manager->persist($taken);

        for ($i = 1; $i <= 27; $i++) {
            $randomMovie = new Movie(sprintf('Another great movie %d', $i));
            $manager->persist($randomMovie);
        }

        $manager->flush();
    }

}