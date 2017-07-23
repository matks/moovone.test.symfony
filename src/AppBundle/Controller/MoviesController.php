<?php

namespace AppBundle\Controller;

use AppBundle\Repository\MovieRepository;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class MoviesController extends FOSRestController
{

    /**
     * @return array
     */
    public function getMoviesAction(Request $request)
    {
        $order = $request->get('order');
        $dir = $request->get('dir');
        $page = $request->query->get('page', 1);

        $movieRepository = $this->getMoviesRepository();
        $moviesPage = $movieRepository->getMovies($page, $order, $dir);

        $context = new Context();
        $context->setGroups(['movie']);

        $view = $this->view($moviesPage);
        $view->setContext($context);

        return $view;
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
