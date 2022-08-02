<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Categorie;
use App\Entity\Fiche;
use App\Form\SearchType;
use App\Repository\FicheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class FitretestController extends AbstractController
{

    public function __construct(EntityManagerInterface $entityManager )
    {
            $this->entityManager = $entityManager;
    }


    #[Route('/fitretest', name: 'app_fitretest')]
    public function index(Request $request )  
    {
            $repository = $this->getDoctrine()->getRepository(Fiche::class);
            $categories = $repository->findBy(array(), array('titre' => 'ASC'));
            
            

            $search= new Search();
            $form=$this->createForm(SearchType::class, $search);

            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()){
                $categories = $this->entityManager->getRepository(Fiche::class)->findwithSearch($search);
                               // dd($search);
            }

        return $this->render('fitretest/index.html.twig', [
            'categories' => $categories,
            'form' => $form->createView(),
            
        ]);
    }
}
