<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Commande;
use App\Entity\LigneCommande;
use App\Entity\ModeleChaussure;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    /**
     * @Route("/commande", name="commande")
     */
    public function index(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if($this->getUser()==null){
          return $this->redirectToRoute("account_login");
        }
        else {
           // $session = $this->get('request_stack')->getCurrentRequest()->getSession();
           $session = $request->getSession();
            $commande = new Commande();
            if (!($session->has('panier'))) {
                //$session->set('cart', array());
                return $this->redirectToRoute('panier_index');
            }
            $panier = $session->get('panier');


            // dd($panier);
            $chaussures = $em->getRepository(ModeleChaussure::class)->findOneBy($session->get('panier'));
            $ligneCommande = [];
            $totalNet = 0;
            foreach ($chaussures as $chaussure) {

                $totalU = ($chaussure->getPrix() * $panier[$chaussures->getId()]);
                $totalNet += floatval($totalU);

                $ligneCommande[$chaussure->getId()] = [
                    'prixU' => $chaussure->getPrix(),
                    'quantite' => intval($panier[$chaussure->getId()]),
                    'totalU' => $totalU,];

                $ligne = new LigneCommande();
                $ligne->setQuantite($panier[$chaussure->getId()]);
                $chaussure->setQuantite(($chaussure->getQuantite()) - ($panier[$chaussure->getId()]));
                $ligne->setModeleChaussure($chaussure->getId());
                $ligne->setCommande($commande);
                $em->persist($ligne);
            }
            $commande->setLigneCommande($ligne);
            $commande->setMontantLigne($totalNet);
            $commande->setDateCommande(new \DateTime());
            $em->persist($commande);
            $em->flush();
            $session->remove('panier');
            $request->getSession()->getFlashBag()->add('success', 'Commande validée avec succès');

            return $this->redirectToRoute('panier_index');
        }
    }
}