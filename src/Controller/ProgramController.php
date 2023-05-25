<?php

namespace App\Controller;

use App\Entity\Episode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;
use App\Entity\Program;
use App\Entity\Season;

#[Route("/program/", name: "program_")]
class ProgramController extends AbstractController
{
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
