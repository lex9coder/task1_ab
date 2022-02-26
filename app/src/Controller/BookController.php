<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Book;
use App\Entity\Author;

class BookController extends AbstractController
{

    /**
     * @Route("/book/create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        if (!$data) {
          return $this->json(['message' => 'Request is empty']);
        }

        try {
            $authorRepository = $this->getDoctrine()->getRepository(Author::class);
            $author = $authorRepository->findOneById($data['author_id']);
        } catch (\Throwable $th) {
            return $this->json(['message' => $th->getMessage()]);
        }

        if (!$author) {
            return $this->json(['message' => 'Author not found']);
        }

        $book = new Book();
        $book->setName($data['name']);
        $book->addAuthor($author);

        $bookRepository = $this->getDoctrine()->getRepository(Book::class);
        $bookRepository->save($book);

        return $this->json([
            'message' => 'Book created',
            'id' => $book->getId()
        ]);
    }

    /**
     * @Route("/book/search", methods={"GET"})
     */
    public function search(Request $request): Response
    {
        $name = $request->query->get('name', '');

        try {
            $jsonContent = [];

            $bookRepository = $this->getDoctrine()->getRepository(Book::class);
            $books = $bookRepository->findByName($name);
            foreach ($books as $key => $book) {
              $jsonContent[] = $book->json();
            }
        } catch (\Throwable $th) {
            return $this->json(['message' => $th->getMessage()]);
        }

        return $this->json($jsonContent);
    }

    /**
     * @Route(
     * "/{lang}/book/{id}",
     * methods={"GET"},
     * requirements={"lang"="en|ru", "id"="\d+"}
     * )
     */
    public function show(string $lang, int $id): Response
    {
        $bookRepository = $this->getDoctrine()->getRepository(Book::class);

        try {
            $book = $bookRepository->findOneById($id);
            $jsonContent = $book->json();
        } catch (\Throwable $th) {
            return $this->json(['message' => $th->getMessage()]);
        }

        return $this->json($jsonContent);
    }


}