<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Movie;

class MovieRepository extends \Doctrine\ORM\EntityRepository
{
    const ORDER_DIRECTION_ASC = 'asc';
    const ORDER_DIRECTION_DESC = 'desc';

    /**
     * @param int $limit
     * @param int $offset
     *
     * @return Movie[]
     */
    public function getMovies($limit, $offset, $order = null, $dir = null)
    {
        if (null === $dir) {
            $dir = self::ORDER_DIRECTION_ASC;
        }

        $this->validateInput($limit, $offset, $order, $dir);

        $qb = $this->createQueryBuilder('movie')
            ->setMaxResults($limit)
            ->setFirstResult($offset);

        if ($order !== null) {
            $qb->orderBy('movie.' . $order, $dir);
        }

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

    /**
     * @return string[]
     */
    public static function getAvailableDirValues()
    {
        return [
            self::ORDER_DIRECTION_ASC,
            self::ORDER_DIRECTION_DESC
        ];
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param string $order
     * @param string $dir
     *
     * @throws \InvalidArgumentException
     */
    private function validateInput($limit, $offset, $order, $dir)
    {
        if (0 === $limit) {
            throw new \InvalidArgumentException('Limit cannot be 0');
        }
        if (0 > $offset) {
            throw new \InvalidArgumentException('Offset must be positive');
        }

        if (null !== $order) {
            if ('name' !== $order) {
                throw new \InvalidArgumentException("Only allowed value for order is 'name'");
            }
            if (false === in_array($dir, self::getAvailableDirValues())) {
                $availableValuesAsString = implode(', ', self::getAvailableDirValues());

                throw new \InvalidArgumentException(sprintf(
                    "Dir must be one of those: %s",
                    $availableValuesAsString
                ));
            }
        }
    }
}