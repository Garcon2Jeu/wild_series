<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;

#[Route("/category/", name: "category_")]
class CategoryController extends AbstractController
{
    #[Route("", name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route("{categoryName<\w+>}", name: "show")]
    public function show(
        string $categoryName,
        CategoryRepository $categoryRepository,
        ProgramRepository $programRepository
    ): Response {
        $category = $categoryRepository->findOneBy(["name" => $categoryName]);

        if (!$category) {
            throw $this->createNotFoundException(
                "no program with name : " . $categoryName . " found in category's table."
            );
        }

        $programs = $programRepository->findBy(["category" => $category->getID()], ["id" => "ASC"]);

        return $this->render("category/show.html.twig", [
            "category" => $category,
            "programs" => $programs
        ]);
    }
}
