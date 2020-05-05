<?php


namespace App\Controller;


use App\Repository\JobRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    public function indexAction(UserRepository $userRepository){
        $persons = $userRepository->findAll();
        return $this->render('home.html.twig',[
            "name" => 'Granit',
            "persons" => $persons
        ]);
    }
    public function oneUserAction($id,UserRepository $userRepository){
        $oneuser = $userRepository->find($id);
        return $this->render('oneuser.html.twig',[
            "name"=> $id,
            "oneuser" => $oneuser
        ]);
    }
    public function nameAction($name){

        return $this->render('name.html.twig',[
            "name"=> $name,
        ]);
    }
    public function aboutAction(){
        $fruits = [
            ["name"=> "berry", "price"=>8, "allergy"=>['pollen', 'autre chose']],
            ["name"=> "coconut", "price"=>12]
        ];
        return $this->render('about.html.twig',[
"fruits"=> $fruits
        ]);
    }
    public function contactAction(){

        return $this->render('contact.html.twig',[
        ]);
    }
}