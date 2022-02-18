<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Book;
use App\Entity\Author;


class AppFixtures extends Fixture
{

    private $generate_count = 10000;

    public function load(ObjectManager $manager): void
    {
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);

        for ($i = 0; $i < $this->generate_count; $i++) {
            $author = new Author();
            $author->setName('author '.$i);
            $manager->persist($author);

            if (($i % 20) === 0) {
                $manager->flush();
                $manager->clear();
            }
        }
        $manager->flush();

        $authorRepository = $manager->getRepository("App\Entity\Author");
        for ($i = 0; $i < $this->generate_count; $i++) {
            $book = new Book();
            $book->setName('book '.$i);

            $authors = $authorRepository->findRandom($this->generate_count);
            foreach ($authors as $author) {
                $book->addAuthor($author);
            }
            $manager->persist($book);

            if (($i % 20) === 0) {
                $manager->flush();
                $manager->clear();
            }
        }

        $manager->flush();
    }
}
