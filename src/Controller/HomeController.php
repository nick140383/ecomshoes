<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use App\Repository\MarqueRepository;
use App\Entity\Marque;
use phpDocumentor\Reflection\Types\AbstractList;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
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



    /**
     * @Route("/", name="home")
     */
    public function index()
    {


        $list = $this->marqueRepository->findAll();
        return $this->render('home/index.html.twig', [
            'list' =>$list
        ]);
    }
}
