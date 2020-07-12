<?php

namespace App\Controller;




use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Repository\ModeleChaussureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;



class PanierController extends AbstractController
{

    /**
     * @Route("/panier", name="panier_index")
     * @param SessionInterface $session
     * @param ModeleChaussureRepository $chaussureRepository
     * @return Response
     */


        public function index( SessionInterface $session, ModeleChaussureRepository  $chaussureRepository)
    {
        $panier = $session->get('panier', []);
        $panierArticles = [];

        foreach($panier as $id => $quantite){
            $panierArticles[] = [
                'chaussure' => $chaussureRepository->find($id),
                'quantite' => $quantite
            ];
        }

        $total = 0;
        foreach($panierArticles as $item){

            $totalitem = $item['chaussure']->getPrix() * $item['quantite'];
            $total += $totalitem;
        }
        return $this->render('panier/index.html.twig', [
            'items' => $panierArticles,
            'total' => $total
        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="panier_add")
     * @param $id
     * @param SessionInterface $session
     * @return RedirectResponse
     */
        public function add($id, SessionInterface $session){

        $panier = $session->get('panier', []);

        if( !empty($panier[$id])){
            $panier[$id]++;

        }else{
            $panier[$id] = 1;
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('panier_index');

    }

    /**
     * @Route("/panier/moins/{id}", name="panier_diminuer")
     * @param $id
     * @param SessionInterface $session
     * @return RedirectResponse
     */
    public function soustraire($id, SessionInterface $session){

        $panier = $session->get('panier', []);

        if( !empty($panier[$id])){
            $panier[$id]--;

        }else{
            $panier[$id] = 1;
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('panier_index');

    }

    /**
     * @Route("/panier/remove/{id}",name="panier_remove")
     * @param $id
     * @param SessionInterface $session
     * @return RedirectResponse
     */
    public function remove($id,SessionInterface $session)
    {
       $panier=$session->get('panier',[]);
       if(!empty($panier[$id]))
       {
           unset($panier[$id]);
       }
        $session->set('panier',$panier);
        return $this->redirectToRoute("panier_index");
    }
}
