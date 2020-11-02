<?php


namespace App\Controller;


use App\Form\CreateThreadFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ThreadController
 * @package App\Controller
 * @Route("/thread")
 * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
 */
class ThreadController extends AbstractController
{
    /**
     * @Route("/create", name="thread_create")
     * @return Response
     */
    public function createThread()
    {
        $form = $this->createForm(CreateThreadFormType::class);
        return $this->render('thread/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}