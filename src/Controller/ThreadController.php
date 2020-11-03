<?php


namespace App\Controller;


use App\Entity\Thread;
use App\Form\CreateThreadFormType;
use App\Service\FormService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @param Request $request
     * @param FormService $formService
     * @return Response
     * @throws \Exception
     */
    public function createThread(Request $request, FormService $formService)
    {
        $errors = [];
        $thread = new Thread();
        $thread->setAuthor($this->getUser());
        $thread->setPublicationDate(new \DateTime('now', new \DateTimeZone('Europe/Paris')));

        $form = $this->createForm(CreateThreadFormType::class, $thread);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $errors = $formService->getErrorMessages($form);
            if ($form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($thread);
                $entityManager->flush();

                $this->addFlash('success', 'Votre Thread a bien été créé.');
            }
        }


        return $this->render('thread/create.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }
}