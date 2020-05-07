<?php
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Job;
use App\Entity\Person;
use App\Entity\Project;
use App\Entity\Skill;
use App\Entity\Techno;
use App\Repository\CategoryRepository;
use App\Repository\JobRepository;
use App\Repository\PersonRepository;
use App\Repository\ProjectRepository;
use App\Repository\SkillRepository;
use App\Repository\TechnoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class EditAdmin extends AbstractController
{
    public function indexAction(){

        return $this->render('admin/homeadmin.html.twig');
    }

    public function catAction(Request $request, $id, CategoryRepository $categoryRepository){
        $hydrate = $this->hydrateform('Category',$request,$categoryRepository,$id);
        if($hydrate === true){
            return $this->redirectToRoute('cat');
        }

        return $this->render('admin/edit/editcat.html.twig',["categorys" => $hydrate['all'], "catForm"=>$hydrate['form']->createView()]
        );
    }
    public function techAction(Request $request, $id,  TechnoRepository $technoRepository){
        $hydrate = $this->hydrateform('Techno',$request,$technoRepository,$id);
        if($hydrate === true){
            return $this->redirectToRoute('tech');
        }

        return $this->render('admin/edit/edittech.html.twig',["technos" => $hydrate['all'], "techForm"=>$hydrate['form']->createView()]
        );
    }
    public function skillsAction(Request $request, $id,
                                 SkillRepository $skillRepository){
        $hydrate = $this->hydrateform('Skill',$request,$skillRepository,$id);
        if($hydrate === true){
            return $this->redirectToRoute('skills');
        }

        return $this->render('admin/edit/editskill.html.twig', ["skillForm"=>$hydrate['form']->createView(),
            "skills"=>$hydrate['all'] ]);
    }

    public function projectsAction(Request $request, $id, ProjectRepository $projectRepository){
        $hydrate = $this->hydrateform('Project',$request,$projectRepository,$id);
        if($hydrate === true){
            return $this->redirectToRoute('projects');
        }

        return $this->render('admin/edit/editproject.html.twig', ["projectForm"=>$hydrate['form']->createView(),
            "projects"=>$hydrate['all'] ]);
    }

    public function delete($repository,$id, $redirect)
    {
        $something = $this->getDoctrine()
            ->getRepository('App\Entity\\'.$repository)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($something);
        $em->flush();

        // Suggestion: add a message in the flashbag

        // Redirect to the table page
        return $this->redirectToRoute($redirect);
    }

    public function hydrateform($type,$request,$projectRepository,$id ){
        $projects = $projectRepository->find($id);
        $form = $this->createForm('App\Form\\'.$type.'Type', $projects);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $project = $form->getData();
            $manager = $this->getDoctrine()->getManager();
            // $manager->getRepository(Skill::class);
            $manager->persist($project);
            $manager->flush();
            return true;
        }
        return [ "form" => $form, "all"=>$projects];
    }
}