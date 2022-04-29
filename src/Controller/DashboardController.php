<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(UserRepository $repository, EntityManagerInterface $entityManager): Response
    {
      $users = $entityManager->getRepository(User::class)->findBy(['is_confirmed' => false]);
        return $this->render('dashboard/index.html.twig', [
            'users' => $users
        ]);
    }
}
