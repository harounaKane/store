<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController{

    private $articles;

    public function __construct(){
        $this->articles = [
            [
                "id" => 1,
                "libelle" => "PC",
                "prix" => 780
            ],
            [
                "id" => 2,
                "libelle" => "Clavier",
                "prix" => 80
            ],
            [
                "id" => 3,
                "libelle" => "Ecran",
                "prix" => 180
            ]
        ];
    }


    #[Route('/', name: 'app_home')]
    public function index(): Response{

        return $this->render('home/index.html.twig', [
            "articles" => $this->articles,
            "title" => "Accueil"
        ]);
    }

    #[Route("/article/show/{id}", name: "app_home_show")]
    public function show($id){
        $art = $this->articles[$id-1];
        
        return $this->render("home/show.html.twig", ["article" => $art]);
    }

    #[Route("/article/somme/prix", name: "app_home_somme")]
    public function somme(){
        $somme = 0;
        foreach($this->articles as $article)
            $somme += $article["prix"];

        
        return $this->render("home/somme.html.twig", ["somme" => $somme]);
    }
}
