<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use App\Repository\MarqueRepository;
use App\Repository\ModeleChaussureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminModeleChaussureController extends AbstractController
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
     * @Route("/admin/modeleChaussure", name="admin_modele_chaussure")
     * @param ModeleChaussureRepository $repo
     * @return
     */
    public function index(ModeleChaussureRepository $repo)
    {
        $list = $this->marqueRepository->findAll();
        return $this->render('admin/admin_modele_chaussure/index.html.twig', [
            'modeleChaussures'=>$repo->findAll(),  'list' =>$list
        ]);
    }
}
