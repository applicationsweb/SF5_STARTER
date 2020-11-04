<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\GerantType;
use App\Repository\UserRepository;
use App\Service\Securizer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/espace-prive/gerants")
 */
class GerantController extends AbstractController
{
    /**
     * @Route("/", name="gerant_index")
     */
    public function index(UserRepository $userRepository): Response
    { 
        $user_id = $this->getUser()->getId();
        if($this->isGranted('ROLE_SUPER_ADMIN')) {
            $users = $userRepository->UsersAllForRole(['ROLE_SUPER_ADMIN', 'ROLE_ADMIN', 'ROLE_MANAGER'], $user_id);
        } else if($this->isGranted('ROLE_ADMIN')) {
            $users = $userRepository->UsersAllForRole(['ROLE_ADMIN', 'ROLE_MANAGER'], $user_id); 
        } else {
            $users = $userRepository->UsersAllForRole(['ROLE_MANAGER'], $user_id); 
        }

        return $this->render('gerant/index.html.twig', ['users' => $users]);
    }

    /**
     * @Route("/new", name="gerant_new", methods="GET|POST")
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();

        $form = $this->createForm(GerantType::class, $user, ['roles' => $this->getUser()->getRoles(), 'edit' => false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $password = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password)->setIsVerified(1);
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Le nouveau gérant a bien été enregistré');

            return $this->redirectToRoute('gerant_index');
        }

        return $this->render('gerant/new.html.twig', [
            'user' => $user,
            'edit' => false,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="gerant_show", methods="GET")
     */
    public function show(User $user): Response
    {
        return $this->render('gerant/show.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/{id}/edit", name="gerant_edit", methods="GET|POST")
     */
    public function edit(Request $request, User $user, Securizer $securizer): Response
    {
        // Interdit de modifier un super administrateur
        if($securizer->isGranted($user, 'ROLE_SUPER_ADMIN')) {
            throw new \Exception("Vous n'avez pas le droit d'accéder à cette ressource.");
        }

        $form = $this->createForm(GerantType::class, $user, ['roles' => $this->getUser()->getRoles(), 'edit' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Le gérant a bien été modifié');

            return $this->redirectToRoute('gerant_index');
        }

        return $this->render('gerant/edit.html.twig', [
            'user' => $user,
            'edit' => true,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="gerant_delete", methods="GET")
     */
    public function delete(Request $request, User $user, Securizer $securizer): Response
    {
        // Interdit de modifier un super supprimer
        if($securizer->isGranted($user, 'ROLE_SUPER_ADMIN')) {
            throw new \Exception("Vous n'avez pas le droit d'accéder à cette ressource.");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        $this->addFlash('success', 'Le gérant a bien été supprimé');
        return $this->redirectToRoute('gerant_index');
    }
}
