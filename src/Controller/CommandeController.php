<?php

namespace App\Controller;
use Illuminate\Database\Eloquent\Model;

use App\Entity\Client;
use App\Entity\Livraison;
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

                return $this->redirectToRoute('panier_index');
            }

            $panier = $session->get('panier');



            $chaussures = $em->getRepository(ModeleChaussure::class)
                ->createQueryBuilder('c')
                ->where('c.id IN (:ids)')
                ->setParameter('ids', array_keys($session->get('panier')))
                ->getQuery()
                ->execute();
            $ligneCommande = [];
            $totalNet = 0;
            foreach ($chaussures as $chaussure) {

                $totalU = ($chaussure->getPrix() * $panier[$chaussure->getId()]);
                $totalNet += floatval($totalU);

                $ligneCommande[$chaussure->getId()] = [
                    'prixU' => $chaussure->getPrix(),
                    'quantite' => intval($panier[$chaussure->getId()]),
                    'totalU' => $totalU,];

                $ligne = new LigneCommande();
                $ligne->setQuantite($panier[$chaussure->getId()]);
                $ligne->setModeleChaussure($chaussure);
                $ligne->setCommande($commande);
                $ligne->setPrix($totalU);
                $em->persist($ligne);
            }
$user=$this->getUser();
            $commande->setMontantLigne($totalNet);
            $commande->setDateCommande(new \DateTime());
            $commande->setClient($this->getUser());
            $adress=$user->getAdresse();
            $ville=$user->getVille();
            $livraison=new Livraison();
            $livraison->setAdresse($adress);
            $livraison->setVille($ville);
            $startDate = Carbon::now();
            $endDate   = Carbon::now()->subDays(7);
            $randomDate = Carbon::createFromTimestamp(Rand($endDate->timestamp, $startDate->timestamp))->format('Y-m-d');
            $livraison->setDateLivraison($randomDate);
           // $livraison = $this->getDoctrine()->getRepository('App\Entity\Livraison')->find($adress);

            $commande->setLivraison($livraison);
            $mode_paiement = $this->getDoctrine()->getRepository('App\Entity\ModePaiement')->find(1);
            $commande->setModePaiement($mode_paiement);

            $em->persist($commande);
            $em->flush();
            $session->remove('panier');
            $request->getSession()->getFlashBag()->add('success', 'Commande validée avec succès');

            return $this->redirectToRoute('panier_index');
        }
    }
}