<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Episode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\ProgramType;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;

#[Route("/program/", name: "program_")]
class ProgramController extends AbstractController
{
    #[Route("new", methods: ["GET", "POST"], name: "new")]
    public function new(
        Program $program,
        Request $request,
        CategoryRepository $categoryRepository,
        ProgramRepository $programRepository
    ) {
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $postData = $request->request->all()["program"];
            $postData["category"] = $categoryRepository->find(["id" => $postData["category"]]);

            $program = Program::withData($postData);
            $programRepository->save($program, true);

            return $this->redirectToRoute("program_index");
        }

        return $this->render("program/new.html.twig", ["form" => $form]);
    }

    #[Route("", methods: ["GET"], name: "index")]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
        return $this->render("program/index.html.twig", ["programs" => $programs]);
    }

    #[Route("{id<\d+>}", methods: ["GET"], name: "show")]
    public function show(Program $program)
    {
        if (!$program) {
            throw $this->createNotFoundException(
                "no program found in program's table."
            );
        }

        return $this->render("program/show.html.twig", ["program" => $program,]);
    }

    #[Route("{program<\d+>}/season/{season<\d+>}", methods: ["GET"], name: "show_season")]
    public function showSeason(Program $program, Season $season)
    {

        return $this->render(
            "program/season_show.html.twig",
            [
                "program" => $program,
                "season" => $season
            ]
        );
    }

    #[Route(
        "{program<\d+>}/season/{season<\d+>}/episode/{episode<\d+>}",
        methods: ["GET"],
        name: "show_episode"
    )]
    public function showEpisode(Program $program, Season $season, Episode $episode)
    {
        return $this->render(
            "program/episode_show.html.twig",
            [
                "program" => $program,
                "season" => $season,
                "episode" => $episode
            ]
        );
    }
}
