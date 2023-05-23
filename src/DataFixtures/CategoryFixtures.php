<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    const CATEGORIES = [
        "Action",
        "Adventure",
        "Animation",
        "Fantastique",
        "Horreur"
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::CATEGORIES as $categoryName) {
            $category = Category::withName($categoryName);
            $manager->persist($category);
            $this->addReference("category_" . $categoryName, $category);
        }

        $manager->flush();
    }
}
