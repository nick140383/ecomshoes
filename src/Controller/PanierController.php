<?php

namespace App\Controller;




use App\Entity\ModeleChaussure;
use App\Entity\Stock;
use App\Entity\Taille;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Repository\ModeleChaussureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        $taille = $session->get('taille', []);
        $panierArticles = $tailleDatas = [];

        $tailleData = $this->getDoctrine()->getRepository(Taille::class)->findAll();
        foreach ($tailleData as $datum) {
            $tailleDatas[$datum->getId()] = $datum->getTaille();
        }

        foreach($panier as $id => $quantite){
            $panierArticles[] = [
                'chaussure' => $chaussureRepository->find($id),
                'quantite' => $quantite,
                'taille' => isset($taille[$id])?$tailleDatas[$taille[$id]]:''
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
    public function add(Request $request, $id, SessionInterface $session){

        $panier = $session->get('panier', []);
        $tailleNo = $request->get('taille', 1);

        if( !empty($panier[$id])){
            $panier[$id]++;
            $taille[$id]=$tailleNo;
        }else{
            $panier[$id] = 1;
            $taille[$id]=$tailleNo;
        }

        $tailleData = $this->getDoctrine()->getRepository(Taille::class)->find($tailleNo);
        $panierData = $this->getDoctrine()->getRepository(ModeleChaussure::class)->find($id);
        if ($tailleData && $panierData) {
            $stock = $this->getDoctrine()->getRepository(Stock::class)->findOneBy(array('taille' => $tailleData, 'modeleChaussure' => $panierData));

            if ($stock) {
                if  ((int)$stock->getQuantite() < (int)$panier[$id]) {
                    $this->addFlash('error', 'Out of stock. Available Qty : '.$stock->getQuantite());
                    return $this->redirectToRoute('detail_chaussure', array('id' => $id));
                } else {
                    $session->set('panier', $panier);
                    $session->set('taille', $taille);

                    return $this->redirectToRoute('panier_index');
                }
            } else {
                $this->addFlash('error', 'Out of stock.');
                return $this->redirectToRoute('detail_chaussure', array('id' => $id));
            }
        } else {
            return $this->redirectToRoute('home');
        }
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
            $panier[$id] = 0;
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
