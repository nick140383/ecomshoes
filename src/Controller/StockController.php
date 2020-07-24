<?php

namespace App\Controller;

use App\Entity\ModeleChaussure;
use App\Entity\Stock;
use App\Form\StockType;
use App\Repository\ClientRepository;
use App\Repository\MarqueRepository;
use App\Repository\ModeleChaussureRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StockController extends AbstractController
{
    /**
     * @var ClientRepository
     */
    private $marqueRepository;

    //private $clientRepository;
    function __construct(MarqueRepository $marqueRepository)
    {
        $this->marqueRepository = $marqueRepository;
        //$this->clientRepository=$clientRepository;
    }


    /**
     * @Route("/stock", name="stock_add")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function createStock(Request $request, EntityManagerInterface $manager)
    {

        $stock = new Stock();
        $list = $this->marqueRepository->findAll();
        $form = $this->createForm(StockType::class, $stock);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($stock);
            $manager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('stock/new.html.twig', [
            'form' => $form->createView(), 'list' => $list
        ]);
    }

    /**
     * @Route("/stock/{id}/edit" ,name="stock_edit",methods={"GET","POST"})
     * @param Stock $stock
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param ModeleChaussure $chaussure
     * @return RedirectResponse|Response
     */
    public function edit(Stock $stock, Request $request, EntityManagerInterface $manager,ModeleChaussure $chaussure)
    {
        $list = $this->marqueRepository->findAll();
        $form = $this->createForm(StockType::class, $stock);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($stock);
            $manager->flush();
            return $this->redirectToRoute('home');


        }
        return $this->render('stock/edition.html.twig',[
            'form'=>$form->createView(),
            'list'=>$list,
            'chaussure'=>$chaussure,
            'stock'=>$stock
        ]);
    }
}
