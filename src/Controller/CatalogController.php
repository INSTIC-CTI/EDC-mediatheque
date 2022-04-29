<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Type;
use App\Form\BookType;
use App\Repository\BookRepository;
use App\Repository\TypeRepository;
use App\Helper\YouMayAlsoLikeManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/catalogue')]

class CatalogController extends AbstractController
{
    #[Route('/', name: 'catalog')]
    public function index(TypeRepository $repository , EntityManagerInterface $entityManager): Response
    {
      $types = $entityManager->getRepository(Type::class)->findAll();
        return $this->render('catalog/index.html.twig', [
            'types' => $types,
        ]);
    }

    #[Route("/livre/{id", name:"catalogue_show")]
      public function show(Book $book, Request $request, EntityManagerInterface $entityManager, YouMayAlsoLikeManager $youMayAlsoLikeManager): Response
    {

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->renderForm('catalog/book.html.twig', [
                'form' => $form,
            ]);
        }

        $types = $entityManager->getRepository(Type::class)->findAll();

        $booksFromTypes =$youMayAlsoLikeManager->displayBooksFromType($book, $types);

        return $this->render('catalog/book.html.twig',[
            'book'=>$book,
            'booksFromTypes'=>$booksFromTypes
        ]);
    }

    #[Route('livre/{id}/reserved', name: "catalogue_show_reserved")]
    public function reserve(Book $book, EntityManagerInterface $entityManager, BookRepository $repository): Response
    {
        if(!$book->getIsReserved()){
            $book->setIsReserved(true);

            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('catalog_show',[
                'id'=>$book->getId(),
            ]);
        }
        return $this->redirectToRoute('catalog_show',[
            'id'=>$book->getId(),
        ]);
    }
}
 