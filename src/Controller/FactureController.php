<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Facture;

use App\Repository\FactureRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Dompdf\Dompdf;
use Dompdf\Options;




class FactureController extends AbstractController
{

//......


    /**
     * @Route("/facture", name="facture_pdf", methods={"GET"})
     */
    public function showPdf():Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();



        $pdfOptions->set('defaultFont', 'Arial');


        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $facture=new Facture();
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('facture/pdf.html.twig', [
            'facture' => $facture
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
        return new Response("The PDF file has been succesfully generated !");
    }

}