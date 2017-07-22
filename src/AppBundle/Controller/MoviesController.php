<?php

namespace AppBundle\Controller;

use AppBundle\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\Request;

class MoviesController extends Controller
{
    const ITEMS_PER_PAGE = 3;

    /**
     * @return array
     * @View()
     */
    public function getMoviesAction(Request $request)
    {
        $order = $request->get('order');
        $dir = $request->get('dir');

        $movieRepository = $this->getMoviesRepository();
        $movies = $movieRepository->getMovies(self::ITEMS_PER_PAGE, 0, $order, $dir);
        $total = $movieRepository->countAll();

        return [
            'data' => $movies,
            'total' => $total,
        ];
    }

    /**
     * @return MovieRepository
     */
    private function getMoviesRepository()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Movie');

        return $repository;
    }
}
