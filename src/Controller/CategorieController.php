<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/categorie')]
class CategorieController extends AbstractController
{   
    private $manager;
    
    function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    #[Route('/', name: 'app_categorie_index')]
    public function index(CategorieRepository $categorieRepo): Response
    {
        return $this->render('categorie/index.html.twig', [
            'categories' => $categorieRepo->findAll(),
        ]);
    }

    #[Route("/new", name: "app_categorie_new")]
    public function new(Request $request){

        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid()){
           $this->manager->persist($categorie);
           $this->manager->flush();

           return $this->redirectToRoute("app_categorie_index");
        }

        return $this->render("categorie/new.html.twig", [
            "categorie" => $categorie,
            "form" => $form
        ]);
    }

    #[Route("/update/{id}", name: "app_categore_update")]
    public function update(Categorie $categorie, Request $req){

        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($req);

        if( $form->isSubmitted() && $form->isValid() ){
            $this->manager->flush();
            return $this->redirectToRoute("app_categorie_index");
        }

        return $this->render("categorie/new.html.twig", [
            "categorie" => $categorie,
            "form" => $form
        ]); 
    }

    #[Route('/{id}', name: "app_categorie_delete", methods:['post'])]
    public function delete(Categorie $categorie, Request $req){

        if($this->isCsrfTokenValid("delete" . $categorie->getId(), $req->request->get("_token"))){
            $this->manager->remove($categorie);
            $this->manager->flush();

        }
            
        return $this->redirectToRoute("app_categorie_index");

    }
}
