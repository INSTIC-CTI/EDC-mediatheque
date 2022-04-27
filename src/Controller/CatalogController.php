<?php

namespace App\Controller;

use App\Entity\Type;
use App\Repository\TypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CatalogController extends AbstractController
{
    #[Route('/catalog', name: 'catalog')]
    public function index(TypeRepository $repository , EntityManagerInterface $entityManager): Response
    {
      $types = $entityManager->getRepository(Type::class)->findAll();
        return $this->render('catalog/index.html.twig', [
            'types' => $types,
        ]);
    }
}
 