<?php

namespace App\Controller;

use App\Entity\ModeleChaussure;
use App\Entity\Photo;
use App\Form\ModeleChaussureType;
use App\Repository\ClientRepository;
use App\Repository\MarqueRepository;
use App\Repository\ModeleChaussureRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



class DetailChaussureController extends AbstractController
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
     * @Route("/detail/chaussure/{id}", name="detail_chaussure")
     */
    public function index(ModeleChaussureRepository $repository, int $id)
    {
        $list = $this->marqueRepository->findAll();
        $chaussure = $repository->find($id);
        return $this->render('detail_chaussure/index.html.twig', [
            'chaussure' => $chaussure,'list'=>$list
        ]);
    }

    /**
     * @Route("/chaussure/new", name="chaussure_nouveau",methods={"GET","POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request)
    {
        $chaussure = new ModeleChaussure();
     //  $manager = $this->getDoctrine()->getManager();

        $form = $this->createForm(ModeleChaussureType::class, $chaussure);
        $form->handleRequest($request);


      //  $photo1=new Photo();

     //   $photo1->setUrl('photo1');
       // $chaussure->getPhotos()->add($photo1);

      //  $photo2=new Photo();
      //  $chaussure->getPhotos() ->add($photo2);
      //  $photo2->setUrl('photo2');

    //    $chaussure->addPhoto($photo1);
     //   $chaussure->addPhoto($photo2);
      //  $manager->persist($photo1);
       // $manager->persist($photo2);



        if($form->isSubmitted() && $form->isValid())
        {

            //on recupere les photos transmises
      $photos=   $form->get('photos')->getData();
            //on boucle sur les photos

        //   $photos =$chaussure->getPhotos();

           foreach($photos as $photo) {

                //on genere un nouveau nom de fichier
                $fileName =  md5(uniqid()) .'.'. $photo->guessExtension();
                //on copie le fichier dans le dossier coverImage
                $photo->move(
                    $this->getParameter('coverImage_directory'),
                    $fileName

                );

               $picture=new Photo();
               $picture->setUrl($fileName);

               $chaussure->addPhoto($picture);
           }
            //on stocke la photo dans la base de donnees




/*
            $file = $chaussure->getUrl();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );
            $chaussure->setUrl($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($chaussure);
            $em->flush();



         // $manager=$this->getDoctrine()->getManager();
           $photos= $form->get('photos')->getData();
            foreach ($photos as $photo) {
                $fileName = md5(uniqid()) . '.' . $photo->getUrl()->guessExtension();
                $photo->move($this->getParameter('coverImage_directory'), $fileName);
                $photo->setUrl($fileName);

            }
     */


/*
       foreach($chaussure->getPhotos() as $photo)
        {
            $photo->setModeleChaussure($chaussure);
            $chaussure->getPhotos()->add($photo);
            $manager->persist($photo);

        }
            $manager->flush();
*/
       $file = $form->get('coverImage')->getData();
            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
            try{
                $file->move(
                    $this->getParameter('coverImage_directory'),
                    $fileName
                );
            }
            catch (fileException $e){

            }



            $chaussure->setCoverImage($fileName);

            $manager=$this->getDoctrine()->getManager();
            $manager->persist($chaussure);
            $manager->flush();

            $this->addFlash('success',
                "Bravo <strong class='text-danger'>{$chaussure->getNom()}</strong> Insertion reussie");
            return $this->redirectToRoute('home');
        }
        $list = $this->marqueRepository->findAll();

        return $this->render('detail_chaussure/nouvelle_chaussure.html.twig', ['form'=>$form->createView(),
            'list'=>$list
        ]);
    }

    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}