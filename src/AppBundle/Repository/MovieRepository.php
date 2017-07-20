<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Movie;

class MovieRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param int $limit
     * @param int $offset
     *
     * @return Movie[]
     */
    public function getMovies($limit, $offset)
    {
        $qb = $this->createQueryBuilder('AppBundle:movie')
            ->setMaxResults($limit)
            ->setFirstResult($offset);

        return $qb->getQuery()->getResult();
    }

    /**
     * @return int
     */
    public function countAll()
    {
        $qb = $this->createQueryBuilder('movie')
            ->select('COUNT(movie)');

        return $qb->getQuery()->getSingleScalarResult();
    }
}
