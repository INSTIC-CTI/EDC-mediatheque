<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
  /**
   * @Route("/register", name="app_register")
   */
  public function index(Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $entity): Response
  {
    $user = new User();
    $form = $this->createForm(RegisterType::class, $user);
    $form->remove('roles');
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $user = $form->getData();
      $password = $hasher->hashPassword($user, $user->getPassword());
      $user->setPassword($password);

      $entity->persist($user);
      $entity->flush();

      $messages = [
        'Votre inscription a bien été enregistrée',
        'un employé de la Reserve va etudier votre demande'
      ];


      return $this->render('register/index.html.twig', [
        'messages' => $messages,
        'form' => $form->createView(),
      ]);
    }
    return $this->render('register/index.html.twig', [
      'form' => $form->createView(),
    ]);
  }
}
