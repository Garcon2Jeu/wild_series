<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;
use App\Entity\Program;
use App\Repository\SeasonRepository;

#[Route("/program/", name: "program_")]
class ProgramController extends AbstractController
{
    #[Route("", methods: ["GET"], name: "index")]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();

        return $this->render("program/index.html.twig", [
            "programs" => $programs
        ]);
    }

    #[Route("{id<\d+>}", methods: ["GET"], name: "show")]
    public function show(
        int $id,
        ProgramRepository $programRepository,
    ) {
        $program = $programRepository->findOneBy(["id" => $id]);
        $seasons = $program->getSeasons();

        if (!$program) {
            throw $this->createNotFoundException(
                "no program with id : " . $id . " found in program's table."
            );
        }

        return $this->render("program/show.html.twig", [
            "program" => $program,
            "seasons" => $seasons
        ]);
    }
}
