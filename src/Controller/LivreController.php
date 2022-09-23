<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Entity\Livre;
use App\Form\LivreType;

use App\Repository\LivreRepository;
use App\Repository\AuteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;

/**
 * @Route("/livre")
 */
class LivreController extends AbstractController
{
    /**
     * @Route("/", name="livre_index", methods={"GET"})
     */
    public function index(LivreRepository $livreRepository): Response
    {
        return $this->render('bookland/livre/index.html.twig', [
            'livres' => $livreRepository->findAll(),
        ]);
        
    }

    //action 13
    /**
     * @Route("/dateparution/{Value1}/{Value2}", name="livre_parution", methods={"GET"})
     */
    public function parution(LivreRepository $livreRepository, $Value1, $Value2): Response
    {
        return $this->render('bookland/livre/index.html.twig', [
            'livres' => $livreRepository->findByDate_parution($Value1, $Value2),
        ]);
    }
    //action 14
     /**
     * @Route("/natdiff", name="livre_natdiff", methods={"GET"})
     */
    public function natdiff(LivreRepository $livreRepository): Response
    {
       $result=array();
       foreach($livreRepository->findAll() as $livre){
           $array=array();
           $cptaut=0;
           $auteurs=$livre->getLivreAuteur();
           foreach($auteurs as $auteur){
               $cptaut=$cptaut+1;
               $testnatdiff=in_array($auteur->getNationalite(),$array);
               if($testnatdiff==false){
                   $array[]=$auteur->getNationalite();
               }
           }
           if ($cptaut==count($array)){
               $result[]=$livre;
           }
       }
       return $this->render('bookland/livre/index.html.twig',['livres'=>$result]); 
    }

    //action 16
     /**
     * @Route("/aut3", name="livre_aut3", methods={"GET"})
     */
    public function aut3(LivreRepository $livreRepository): Response
    {
       $result=array();
       foreach($livreRepository->findAll() as $livre){
           $array=array();
           $cptaut=0;
           $auteurs=$livre->getLivreAuteur();
           foreach($auteurs as $auteur){
               $cptaut=$cptaut+1;
               $testnatdiff=in_array($auteur->getNomPrenom(),$array);
               if($testnatdiff==false){
                   $array[]=$auteur->getNomPrenom();
               }
            }
           if ($cptaut>=3){
               $result[]=$livre;
           }
        
       }
       return $this->render('bookland/livre/index.html.twig',['livres'=>$result]); 
    }

    

    //action 15
    /**
     * @Route("/dateparutionNote/{datedebut}/{datefin}/{notemin}/{notemax}", name="livre_parutionnote", methods={"GET"})
     */
    public function parutionNote(LivreRepository $livreRepository, $datedebut, $datefin, $notemin, $notemax): Response
    {
        return $this->render('bookland/livre/index.html.twig', [
            'livres' => $livreRepository->findByDate_parutionANDNote($datedebut, $datefin, $notemin, $notemax),
        ]);
    }
    //action 17
    /**
     * @Route("/parite", name="livre_parite", methods={"GET"})
     */
    public function parite(LivreRepository $livreRepository): Response
    {
       $result=array();
       foreach($livreRepository->findAll() as $livre){
           $array=array();
           $cptautM=0;
           $cptautF=0;
           $auteurs=$livre->getLivreAuteur();
           foreach($auteurs as $auteur){
               
               
               if($auteur->getSexe()=='M'){
                   $array[]=$auteur->getNomPrenom();
                   $cptautM=$cptautM+1;
               }
               if($auteur->getSexe()=='F')
               {
                    $array[]=$auteur->getNomPrenom();
                    $cptautF=$cptautF+1;
               }
           }
           $moyenne=($cptautM+$cptautF);
           if (($moyenne % 2)==0){
                $result[]=$livre;
            }
       }
       return $this->render('bookland/livre/index.html.twig',['livres'=>$result]); 
    }


    /**
     * @Route("/new", name="livre_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $livre = new Livre();
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($livre);
            $entityManager->flush();

            return $this->redirectToRoute('livre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bookland/livre/new.html.twig', [
            'livre' => $livre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="livre_show", methods={"GET"})
     */
    public function show(Livre $livre): Response
    {
        return $this->render('bookland/livre/show.html.twig', [
            'livre' => $livre,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="livre_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Livre $livre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('livre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bookland/livre/edit.html.twig', [
            'livre' => $livre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="livre_delete", methods={"POST"})
     */
    public function delete(Request $request, Livre $livre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$livre->getId(), $request->request->get('_token'))) {
            $entityManager->remove($livre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('livre_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/chercherLivre/{value1}", name="livre_recherche",methods={"GET"})
     */
    public function chercherLivre(LivreRepository $livreRepository,$value1): Response
    {
    

        return $this->render('bookland/livre/index.html.twig', ['livres' => $livreRepository->findByOnetitre($value1)]); 
    }
    
        
       


        
   
    
}
