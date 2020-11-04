<?php

namespace App\Controller;

use App\Form\AccountType;
use App\Entity\PasswordUpdate;
use App\Form\PasswordUpdateType;
use App\Repository\UserRepository;
use App\Service\AuthorizeUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * Affiche le profil de l'utilisateur connecté sur le back-office
     *
     * @Route("/espace-prive/profil", name="account_admin_profile")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function adminProfile(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $form = $this->createForm(AccountType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            $this->addFlash('success', 'Votre compte a été mis à jour.');
            
            return $this->redirectToRoute('account_admin_profile');
        }
        return $this->render('account/profile-admin.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Affiche le profil de l'utilisateur connecté sur le front-office
     *
     * @Route("/profil", name="account_profile")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function profile(Request $request, AuthorizeUser $authorizeUser)
    {
        if(!$authorizeUser->isAuthorize()) {
            $this->addFlash('danger', 'Merci de valider votre compte pour consulter cette page. Vérifiez vos spams !');
            return $this->redirectToRoute('front_index'); 
        }

        $manager = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $form = $this->createForm(AccountType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            $this->addFlash('success', 'Votre compte a été mis à jour.');
            
            return $this->redirectToRoute('account_profile');
        }
        return $this->render('account/profile.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Modification du mot de passe de l'utilisateur connecté au back-office
     *
     * @Route("/espace-prive/modification-du-mot-de-passe", name="account_admin_password")
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     *
     * @return Response
     */
    public function AdminUpdatePassword(Request $request, UserPasswordEncoderInterface $encoder, UserRepository $userRepository)
    {
        $passwordUpdate = new PasswordUpdate();
        $user = $this->getUser();
        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPassword = $encoder->encodePassword($user, $passwordUpdate->getNewPassword());
            $userRepository->upgradePassword($user, $newPassword);

            $this->addFlash('success', 'Votre mot de passe a été mis à jour.');
            return $this->redirectToRoute('account_admin_profile');
        }

        return $this->render('account/update-password-admin.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Modification du mot de passe de l'utilisateur connecté au front-office
     *
     * @Route("/modification-du-mot-de-passe", name="account_password")
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     *
     * @return Response
     */
    public function UpdatePassword(Request $request, UserPasswordEncoderInterface $encoder, UserRepository $userRepository, AuthorizeUser $authorizeUser)
    {
        if(!$authorizeUser->isAuthorize()) {
            $this->addFlash('danger', 'Merci de valider votre compte pour consulter cette page. Vérifiez vos spams !');
            return $this->redirectToRoute('front_index'); 
        }

        $passwordUpdate = new PasswordUpdate();
        $user = $this->getUser();
        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPassword = $encoder->encodePassword($user, $passwordUpdate->getNewPassword());
            $userRepository->upgradePassword($user, $newPassword);

            $this->addFlash('success', 'Votre mot de passe a été mis à jour.');
            return $this->redirectToRoute('account_profile');
        }

        return $this->render('account/update-password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}