<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    const LOREM = "Lorem ipsum dolor sit amet consectetur adipisicing elit.
    Officiis corrupti sunt est dolores. Quis modi rerum asperiores tempore 
    facere eum atque, eaque ea eveniet incidunt, beatae dolores, officiis iste ipsa?";

    public function load(ObjectManager $manager): void
    {
        $categories = [];
        for ($i = 0; $i < 10; $i++) {
            $category = Category::withName("category_" . $i + 1);
            $categories[] = $category;
            $manager->persist($category);
        }

        $programTemplate = [
            "title" => "",
            "synopsis" => self::LOREM,
            "poster" => "path_to_poster",
            "category" => ""

        ];

        $programs = [];
        for ($i = 0; $i < 30; $i++) {
            $programTemplate["title"] = "program_" . $i + 1;
            $programTemplate["category"] = $categories[array_rand($categories)];

            $program = Program::withData($programTemplate);
            $programs[] = $program;

            $manager->persist($program);
        }

        $seasonTemplate = [
            "program" => "",
            "number" => "",
            "year" => "",
            "description" => self::LOREM
        ];

        $seasons = [];
        foreach ($programs as $program) {
            $numberOfSeasons = rand(1, 12);

            for ($i = 0; $i < $numberOfSeasons; $i++) {
                $seasonTemplate["program"] = $program;
                $seasonTemplate["number"] = $i + 1;
                $seasonTemplate["year"] = $i + 2000;

                $season = Season::withData($seasonTemplate);
                $seasons[] = $season;

                $manager->persist($season);
            }
        }

        $episodeTemplate = [
            "season" => "",
            "title" => "",
            "number" => "",
            "synopsis" => self::LOREM
        ];

        $episodes = [];
        foreach ($seasons as $season) {
            $numberOfEpisodes = rand(12, 24);

            for ($i = 0; $i < $numberOfEpisodes; $i++) {

                $episodeTemplate["season"] = $season;
                $episodeTemplate["title"] = "episode_" . $i + 1;
                $episodeTemplate["number"] = $i + 1;

                $episode = Episode::withData($episodeTemplate);
                $episodes[] = $episode;

                $manager->persist($episode);
            }
        }

        $manager->flush();
    }
}
