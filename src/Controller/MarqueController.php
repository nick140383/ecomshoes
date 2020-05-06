<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Marque;
use App\Entity\ModeleChaussure;
use App\Repository\MarqueRepository;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MarqueController extends AbstractController
{
    /**
     * @var ClientRepository
     */
    private $marqueRepository;
    private $clientRepository;
    function __construct(MarqueRepository $marqueRepository,ClientRepository $clientRepository)
    {
        $this->marqueRepository = $marqueRepository;
        $this->clientRepository=$clientRepository;
    }
    /*
    /**
     * @Route("/marques", name="marque")
     */
    /*
    public function laMarque()
    {
        $list = $this->marqueRepository->findAll();
        return $this->render('home/index.html.twig', [
            'list' =>$list
        ]);
    }
  */
    /**
     * @Route("/marques/{id}", name="marques.details")
     */

    public function afficheChaussure(Request $request, int $id)
    {
        $list = $this->marqueRepository->findAll();

        $marque = $this->marqueRepository->find($id);
        $chaussures = $marque->getModeleChaussures();
       // $repo=$this->getDoctrine()->getrepository(ModeleChaussure::class);
       // $chaussures=$repo->findAll();

        return $this->render('marque/chaussures.html.twig', [
            'list'=>$list, 'chaussures'=>$chaussures]);
    }
}
