<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Form\EtudiantType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController{


    #[Route('/', name: 'app_home')]
    public function index(ArticleRepository $articleRepo, Request $req): Response{

        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($req);



        return $this->render('home/index.html.twig', [
            "articles" => $articleRepo->findAll(),
            "title" => "Accueil",
            "form" => $form
        ]);
    }

}
