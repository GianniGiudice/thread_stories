<?php


namespace App\Controller;


use App\Entity\Avatar;
use App\Entity\User;
use App\Form\UploadAvatarFormType;
use App\Form\UploadBannerFormType;
use App\Repository\ThreadRepository;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller
 * @Route("/user")
 */
class UserController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/profile/{pseudo}", name="profile_home")
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

    /**
     * @Route("/settings", name="settings")
     * @param Request $request
     * @param UserService $userService
     * @return Response
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     */
    public function settings(Request $request, UserService $userService)
    {
        $avatar = $userService->getAvatar();
        $banner = $userService->getBanner();
        $form = $this->createForm(UploadAvatarFormType::class, $avatar);
        $banner_form = $this->createForm(UploadBannerFormType::class, $banner);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($avatar);
            $this->entityManager->flush();
            $this->addFlash('success', 'Votre avatar a bien été mis à jour.');
        }

        $banner_form->handleRequest($request);
        if ($banner_form->isSubmitted() && $banner_form->isValid()) {
            $this->entityManager->persist($banner);
            $this->entityManager->flush();
            $this->addFlash('success', 'Votre bannière a bien été mise à jour.');
        }

        return $this->render('user/settings.html.twig', [
            'form' => $form->createView(),
            'banner_form' => $banner_form->createView(),
            'user' => $this->entityManager->getRepository(User::class)->findOneBy(['email' => $this->getUser()->getUsername()])
        ]);
    }

}