<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Controller
 * @Route("/")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_show")
     * @return Response
     */
    public function index()
    {
        return $this->render('home/show.html.twig', [

        ]);
    }
}