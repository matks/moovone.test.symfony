<?php

namespace AppBundle\Domain;

use AppBundle\Entity\Movie;
use Doctrine\Common\Persistence\ManagerRegistry;

class MoviesManager
{
    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    /**
     * @param ManagerRegistry $doctrine
     */
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param Movie $movie
     *
     * @return bool
     *
     * @throws \InvalidArgumentException
     */
    public function deleteMovie(Movie $movie)
    {
        if (Movie::STATUS_VALID !== $movie->getStatus()) {
            throw new \InvalidArgumentException(sprintf(
                'Movie %d cannot be deleted',
                $movie->getId()
            ));
        }

        $movie->delete();

        $entityManager = $this->doctrine->getManager();
        $entityManager->flush($movie);

        return true;
    }
}
