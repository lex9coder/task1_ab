<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

use App\Entity\Author;

class AuthorController extends AbstractController
{

    /**
     * @Route("/author/create", methods={"POST"})
     */
    public function create(): Response
    {
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);

        if (!$data) {
          return $this->json(['message' => 'Request is empty']);
        }

        if (!array_key_exists('name', $data)) {
          return $this->json(['message' => 'Field Name is empty']);
        }

        $author = new Author();
        $author->setName($data['name']);

        $authorRepository = $this->getDoctrine()->getRepository(Author::class);
        $authorRepository->save($author);

        return $this->json([
            'message' => 'Author added',
            'id' => $author->getId()
        ]);
    }


    /**
     * @Route("/author/{id}", methods={"PUT"}, requirements={"id"="\d+"})
     */
    public function update(Request $request, $id): Response
    {
        $data = json_decode($request->getContent(), true);

        $authorRepository = $this->getDoctrine()->getRepository(Author::class);
        $author = $authorRepository->find($id);

        if (!$author) {
            return $this->json(['message' => 'Author not found']);
        }

        if (!$data) {
          return $this->json(['message' => 'Request is empty']);
        }

        if (!array_key_exists('name', $data)) {
          return $this->json(['message' => 'Field Name is empty']);
        }

        $author->setName($data['name']);
        $authorRepository->save($author);

        return $this->json([
            'message' => 'Author updated',
            'id' => $author->getId()
        ]);
    }

    /**
     * @Route("/author/{id}", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function delete(Request $request, $id): Response
    {
        $authorRepository = $this->getDoctrine()->getRepository(Author::class);
        $author = $authorRepository->find($id);

        if (!$author) {
            return $this->json(['message' => 'Author not found']);
        }
        $authorRepository->delete($author);

        return $this->json(['message' => 'Book deleted']);
    }


    /**
     * @Route("/author/search", methods={"GET"})
     */
    public function search(Request $request): Response
    {
        $name = $request->query->get('name', '');

        try {
            $authorRepository = $this->getDoctrine()->getRepository(Author::class);
            $authors = $authorRepository->findByName($name);

            $jsonContent = [];
            foreach($authors as $author) {
                $jsonContent[] = $author->json();
            }
        } catch (\Throwable $th) {
            return $this->json(['message' => $th->getMessage()]);
        }

        return $this->json($jsonContent);
    }

}