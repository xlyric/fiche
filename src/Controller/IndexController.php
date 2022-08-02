<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Fiche;
use App\Form\SearchType;
use App\Repository\FicheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{

    public function __construct(EntityManagerInterface $entityManager )
    {
            $this->entityManager = $entityManager;
    }
    

    #[Route('/', name: 'app_index')]
    #[Route("/recherche", name: "rechercheform")]
    public function index(Request $request )
    {

      /*  $repository = $this->getDoctrine()->getRepository(Fiche::class);
        $Clients = $repository->findBy(array(), array('titre' => 'ASC'));

        return $this->render('index/index.html.twig', [
            'articles' => $Clients,
        ]); */

        $repository = $this->getDoctrine()->getRepository(Fiche::class);
            $categories = $repository->findBy(array(), array('id' => 'DESC'));
            
            $nombre = count($categories);
            

            $search= new Search();
            $form=$this->createForm(SearchType::class, $search);

            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()){
                $categories = $this->entityManager->getRepository(Fiche::class)->findwithSearch($search);
                $nombre = count($categories);
                             
            }

            
        return $this->render('fitretest/index.html.twig', [
            'categories' => $categories,
            'form' => $form->createView(),
            'result'=> $nombre,
            
        ]);


    }

    /**
     * @Route("/recherche/{id}", name="recherche")
     */
    public function detail(FicheRepository $repository,$id): Response
    {

        $Client = $repository->recherche($id);
        return $this->render('recherche/index.html.twig', [
            "articles" => $Client
        ]);
    }
    
}
