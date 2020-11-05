<?php


namespace App\Controller;


use App\Entity\User;
use App\Repository\ThreadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/{pseudo}", name="profile_home")
     * @param User $user
     * @param ThreadRepository $threadRepository
     * @return Response
     */
    public function profile(User $user, ThreadRepository $threadRepository)
    {
        return $this->render('user/profile.html.twig', [
            'user' => $user,
            'threads' => $threadRepository->findBy(['author' => $user], ['publication_date' => 'DESC'])
        ]);
    }
}