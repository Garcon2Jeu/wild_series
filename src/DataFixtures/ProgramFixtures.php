<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Program;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $programs = [
            "strangerThings" => [
                "title" => "Stranger Things",
                "synopsis" => "Little girl's nose bleed makes things fly",
                "poster" => "path_to_poster",
                "category" => $this->getReference("category_Horreur")
            ],

            "wwdits" => [
                "title" => "What We do in the Shadows",
                "synopsis" => "Bunch of vampires being dum",
                "poster" => "path_to_poster",
                "category" => $this->getReference("category_Fantastique")
            ],

            "bojack" => [
                "title" => "Bojack Horseman",
                "synopsis" => "Depressed Horse actor doesn't like being a horrible person",
                "poster" => "path_to_poster",
                "category" => $this->getReference("category_Animation")
            ],

            "andor" => [
                "title" => "Andor",
                "synopsis" => "Disney wanted money",
                "poster" => "path_to_poster",
                "category" => $this->getReference("category_Adventure")
            ],

            "aot" => [
                "title" => "Attack on Titan",
                "synopsis" => "Eren!!!!!!!!!!!",
                "poster" => "path_to_poster",
                "category" => $this->getReference("category_Action")
            ],
        ];

        foreach ($programs as $programData) {
            $program = Program::withData($programData);
            $manager->persist($program);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }
}
