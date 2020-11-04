<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/espace-prive/tableau-de-bord")
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="dashboard_index")
     */
    public function index(UserRepository $userRepository): Response
    {
        $user_id = $this->getUser()->getId();
        if($this->isGranted('ROLE_SUPER_ADMIN')) {
            $users = $userRepository->UsersAllForRole(['ROLE_SUPER_ADMIN', 'ROLE_ADMIN', 'ROLE_MANAGER'], $user_id, 1);
        } else if($this->isGranted('ROLE_ADMIN')) {
            $users = $userRepository->UsersAllForRole(['ROLE_ADMIN', 'ROLE_MANAGER'], $user_id, 1); 
        } else {
            $users = $userRepository->UsersAllForRole(['ROLE_MANAGER'], $user_id, 1); 
        }

        return $this->render('dashboard/index.html.twig', [
            'gerants' => $users["total"]
        ]);
    }
}
