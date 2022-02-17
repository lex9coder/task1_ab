<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

use App\Entity\Author;
use App\Repository\AuthorRepository;

class AuthorController extends AbstractController
{

    /**
     * @Route("/author/create", methods={"POST"})
     */
    public function create(AuthorRepository $authorRepository): Response
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

        $authorRepository->save($author);

        return $this->json([
            'message' => 'Author added',
            'id' => $author->getId()
        ]);
    }

    /**
     * @Route("/author/search", methods={"GET"})
     */
    public function search(AuthorRepository $authorRepository): Response
    {

        $request = Request::createFromGlobals();
        $name = $request->query->get('name', '');

        try {
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