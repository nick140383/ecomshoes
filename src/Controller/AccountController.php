<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\PasswordUpdate;
use App\Form\AccountType;
use App\Form\PasswordUpdateType;
use App\Form\RegistrationType;
use App\Repository\ClientRepository;
use App\Repository\MarqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    /**
     * @var ClientRepository
     */
    private $marqueRepository;
    private $clientRepository;
    function __construct(MarqueRepository $marqueRepository,ClientRepository $clientRepository)
    {
        $this->marqueRepository = $marqueRepository;
        $this->clientRepository=$clientRepository;
    }

    /**
     * @Route("/registration", name="account_registration")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new Client();
        $list = $this->marqueRepository->findAll();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setMotDePasse($hash);
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success',
                "Bravo <strong class='text-danger'>{$user->getNom()}</strong> Inscription reussie");

            return $this->redirectToRoute('account_login', ['list' =>$list]);
        }

        return $this->render('account/registration.html.twig', [
            'form' => $form->createView(),'list'=>$list
        ]);
    }

    /**
     * @Route("/login", name="account_login")
     * @param AuthenticationUtils $utils
     * @return Response
     */
    public function login(AuthenticationUtils $utils)
    {

        $list = $this->marqueRepository->findAll();

        $error = $utils->getLastAuthenticationError();

        return $this->render('account/login.html.twig', ['hasError' => $error !== null,'list' =>$list]);




    }

    /**
     * @Route("/signout", name="account_logout")
     */
    public function logout(){}

    /**
     * @Route("/account/profile", name="account_profile")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function profile(Request $request, EntityManagerInterface $manager)
    {
        $list = $this->marqueRepository->findAll();
        $user = $this->getUser();
        $form = $this->createForm(AccountType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les données du profil ont été modifiées avec succès !"
            );
            return $this->redirectToroute('home');
        }
        return $this->render('account/profile.html.twig', [
            'form' => $form->createView(),'list' =>$list
        ]);
    }

    /**
     * @Route("/account/updatePassword", name="account_password")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function updatePassword(Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $manager)
    {
        $list = $this->marqueRepository->findAll();
        $passwordUpdate = new PasswordUpdate();

        $user=$this->getUser();

        $form=$this->createForm(PasswordUpdateType::class, $passwordUpdate);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            if(!password_verify($passwordUpdate->getOldPassword(), $user->getPassword()))
            {
              $form->get('oldPassword')->adderror(new FormError("le mot de passe que vous avez tapé
              n'est pas votre de passe actuel!"));
            }
            else
            {
                $newPassword = $passwordUpdate->getNewPassword();
                $hash = $encoder->encodePassword($user, $newPassword);
                $user->setMotDePasse($hash);
                $manager->persist($user);
                    $manager->flush();
                $this->addFlash(
                    'success',
                    "Votre mot de passe a bien été modifié!"
                );
                return $this->redirectToroute('home');
            }
        }
        return $this->render('account/password.html.twig', [
            'form' => $form->createView(),'list' =>$list]);
    }
}