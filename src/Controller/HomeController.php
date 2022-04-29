<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(BookRepository $repository): Response
    {
      $favoriteBooks = $repository->findByIsFavorite();
      return $this->render('home/index.html.twig',[
          'favoriteBooks'=>$favoriteBooks
      ]);
    }
}
