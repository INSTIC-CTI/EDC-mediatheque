<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Type;
use App\Form\BookType;
use App\Form\TypeType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route("/dashboard/livre")]

class BookController extends AbstractController
{
  #[Route('/', name: 'book_index')] // method =GET
  public function index(BookRepository $bookRepository): Response
  {
    $books = $bookRepository->findAll();
    return $this->render('book/index.html.twig', [
      'books' => $books,
    ]);
  }
  #[Route('/nouveau-livre', name: 'book_new')] // method =GET | post
  public function new(Request $request, EntityManagerInterface $entityManager): Response
  {
    $book = new Book();
    $form = $this->createForm(BookType::class, $book);

    $type = new Type();
    $formType = $this->createForm(TypeType::class,$type);

    $form->handleRequest($request);
    $formType->handleRequest($request);

    if($formType->isSubmitted() && $formType->isValid()){
        $entityManager->persist($type);
        $entityManager->flush();

        return $this->redirectToRoute('book_new');

    }

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($book);
        $entityManager->flush();


        return $this->redirectToRoute('book_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('book/new.html.twig', [
        'book' => $book,
        'form' => $form,
        'formType'=>$formType
    ]);
  }

  #[Route('/{id}', name: "book_show")] // method=GET
  public function show(Book $book): Response
  {
    return $this->render('book/show.html.twig', [
      'book' => $book,
    ]);
  }

  #[Route('/{id}/modifier', name: "book_edit")] // method=GET |POST
  public function edit(Request $resquest, Book $book, EntityManagerInterface $entityManager): Response
  {
    $form = $this->createForm(BookType::class, $book);
    $form->handleRequest($resquest);

    $type = new Type();
    $formType = $this->createForm(Type::class, $type);
    $formType->handleRequest($resquest);

    if ($formType->isSubmitted() && $formType->isValid()) {
      $entityManager->persist($type);
      $entityManager->flush();

      return $this->redirectToRoute('book_edit', [
        'id' => $book->getId(),
      ]);
    }

    if ($form->isSubmitted() && $form->isValid()) {
      $entityManager->flush();
      return $this->redirectToRoute('book_index', [], Response::HTTP_SEE_OTHER);
    }
    return $this->render('book/edit.html.twig', [
      'book' => $book,
      'form' => $form,
      'formType' => $formType,
    ]);
  }

  #[Route('/{id}', name: "book_delete")] // method=POST
  public function delete(Request $request, Book $book, EntityManagerInterface $entityManager)
  {
    if ($this->isCsrfTokenValid('delete' . $book->getId(), $request->request->get('_token'))) {
      $entityManager->remove($book);
      $entityManager->flush();
    }
    return $this->redirectToRoute('book_index', [], Response::HTTP_SEE_OTHER);
  }
}
