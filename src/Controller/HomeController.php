<?php


namespace App\Controller;


use App\Repository\ThreadRepository;
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
     * @param ThreadRepository $threadRepository
     * @return Response
     */
    public function index(ThreadRepository $threadRepository)
    {
        return $this->render('home/show.html.twig', [
            'threads' => $threadRepository->findBy([], ['publication_date' => 'DESC'])
        ]);
    }
}