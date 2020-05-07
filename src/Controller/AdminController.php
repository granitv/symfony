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
use App\Service\FormsManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{
    public function indexAction(){
        return $this->render('admin/homeadmin.html.twig');
    }

    public function catAction(Request $request,  CategoryRepository $categoryRepository){
        $category = new Category();
        $hydrate = $this->hydrateform('Category',$request,$categoryRepository,$category);
        if($hydrate === true){
            return $this->redirectToRoute('cat');
        }
        return $this->render('admin/category.html.twig',["categorys" => $hydrate['all'], "catForm"=>$hydrate['form']->createView()]
        );
    }

    public function techAction(Request $request,  TechnoRepository $technoRepository){
        $techno = new Techno();
        $hydrate = $this->hydrateform('Techno',$request,$technoRepository,$techno);
        if($hydrate === true){
            return $this->redirectToRoute('tech');
        }
        return $this->render('admin/techno.html.twig',["technos" => $hydrate['all'], "techForm"=>$hydrate['form']->createView()]
        );
    }

    public function skillsAction(Request $request, SkillRepository $skillRepository){
        $skill = new Skill();
        $hydrate = $this->hydrateform('Skill',$request,$skillRepository,$skill);
        if($hydrate === true){
            return $this->redirectToRoute('skills');
        }
        return $this->render('admin/skills.html.twig', ["skillForm"=>$hydrate['form']->createView(),
            "skills"=>$hydrate['all'] ]);
    }

    public function projectsAction(Request $request, ProjectRepository $projectRepository){
        $project = new Project();
        $hydrate = $this->hydrateform('Project',$request,$projectRepository,$project);
        if($hydrate === true){
            return $this->redirectToRoute('projects');
        }
        return $this->render('admin/projects.html.twig', ["projectForm"=>$hydrate['form']->createView(),
            "projects"=>$hydrate['all'] ]);
    }

    public function hydrateform($type,$request,$projectRepository,$project  ){
        $projects = $projectRepository->findAll();
        $form = $this->createForm('App\Form\\'.$type.'Type', $project);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $project = $form->getData();
            $manager = $this->getDoctrine()->getManager();
            // $manager->getRepository(Skill::class);
            if($type == 'Techno' || $type == 'Skill' || $type == 'Project'){
                $skill = $form->getData();
                $file = $form->get('image')->getData();

                if($file){
                    /* $newFileName = FormsManager::handleFileUpload($file, 'uploads');
                    $skill->setImage('../uploads/'.$newFileName); */
                    //                                                  $this->getParameter('uploads'));
                    $newFileName = FormsManager::handleFileUpload($file, $this->getParameter('uploads'));
                    $skill->setImage($newFileName);
                }

            }
            $manager->persist($project);
            $manager->flush();
            return true;
        }
     return [ "form" => $form, "all"=>$projects];
    }
}