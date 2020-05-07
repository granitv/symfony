<?php
namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use App\Repository\SkillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class DefaultController extends AbstractController
{
    public function indexAction(SkillRepository $skillRepository, ProjectRepository $projectRepository){
        $skills = $skillRepository->findAll();
        $projects = $projectRepository->findAll();
        return $this->render('portfolio.html.twig', [
            "skills" =>$skills,
            "projects" => $projects
        ]);
    }

}