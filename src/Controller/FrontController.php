<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class FrontController extends AbstractController
{
    /**
     * @Route("/", name="front_index", methods={"GET"})
     */
    public function index(): Response
    {        
        return $this->render('front/index.html.twig');
    }
}
