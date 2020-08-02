<?php

namespace App\Controller;

use App\Entity\ModeleChaussure;
use App\Entity\Stock;
use App\Entity\Taille;
use App\Form\StockType;
use App\Repository\ClientRepository;
use App\Repository\MarqueRepository;
use App\Repository\ModeleChaussureRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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


         $taille= $this->getDoctrine()->getRepository(Taille::class)->findAll();
        $tail=[];
        $stock = new Stock();
        $list = $this->marqueRepository->findAll();
        $form = $this->createForm(StockType::class, $stock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


          if(!$stock) {

              $manager->persist($stock);
              $manager->flush();


              $manager->persist($stock);
              $manager->flush();
              return $this->redirectToRoute('home');
          }
          else{
              $this->redirectToRoute('stock_edit');
          }
        }

        return $this->render('stock/new.html.twig', [
            'form' => $form->createView(),
            'list' => $list,
            'stock'=>$stock
        ]);
    }

    /**
     * @Route("/stock/{id}/edit" ,name="stock_edit",methods={"GET","POST"})
     * @ParamConverter("id", options={"id": "id"})

     * @param Stock $stock
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param ModeleChaussure $chaussure
     * @return RedirectResponse|Response
     */
    public function edit(Stock $stock, Request $request, EntityManagerInterface $manager,ModeleChaussure $chaussure,$id)
    {
        $list = $this->marqueRepository->findAll();
        $form = $this->createForm(StockType::class, $stock);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($stock);
            $manager->flush();
            return $this->redirectToRoute('stock_edit',['id'=>$id]);


        }
        return $this->render('stock/edition.html.twig',[
            'form'=>$form->createView(),
            'list'=>$list,
            'chaussure'=>$chaussure,
            'stock'=>$stock
        ]);
    }
}
