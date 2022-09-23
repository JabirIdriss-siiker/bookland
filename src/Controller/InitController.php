<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Entity\Genre;
use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class InitController extends AbstractController
{
   /**
     * @Route("/init", name="init")
     * @param ValidatorInterface $validator
     * @return Response
     */
    public function index(ValidatorInterface $validator): Response
    {
        $entityManager = $this->getDoctrine()->getManager();


        $arr_genre = [
            'science fiction',
            'policier',
            'philosophie',
            'économie',
            'psychologie'
        ];

        $arr_auteur = [

            ['Richard Thaler','M', "12/12/1945", 'USA'],

            ['Cass Sunstein','M',"23/11/1943", 'allemagne'],

            ['Francis Gabrelot','M',"29/01/1967", 'France'],

            ['Ayn Rand','F',"21/06/1950", 'russie'],

            ['Duschmol','M',"23/12/2001", 'groland'],

            ['Nancy Grave','F',"24/10/1952", 'USA'],

            ['James Enckling','M',"03/07/1970", 'USA'],

            ['Jean Dupont','M',"03/07/1970", 'France'],
        ];

        $arr_livre = [
            ['Symfonystique',  "978-2-07-036822-8", 117,  "20/01/2008", 8,  ["policier", "philosophie"], ["Francis Gabrelot", "Ayn Rand", "Nancy Grave"]],

            [' La grève',  "978-2-251-44417-8", 1245,  "12/06/1961", 19,  ["philosophie"], ["Ayn Rand", "James Enckling"]],

            [' Symfonyland',  "978-2-212-55652-0", 131,  "17/09/1980", 15,  ["science fiction"], ["Jean dupont","Ayn Rand", "James Enckling"]],

            [' Ma vie',  "978-0-300-12223-7", 5,  "08/11/2021", 3,  ["policier"], ["Jean dupont"]],
            
            [' Négociation Complexe',  "978-2-0807-1057-4", 234,  "25/09/1992", 16,  ["psychologie"], ["Richard Thaler", "Cass Sunstein"]],

            [' Le monde comme volonté et comme représentation', "978-0-141-18786-0", 1987,  "09/11/1821", 19,["philosophie"], ["Nancy Grave","Francis Gabrelot"]],
        ];

        foreach ($arr_genre as $nom) {

            $genre = new Genre();
            $genre->setNom($nom);
            $errors = $validator->validate($genre);
            if (count($errors) == 0) {
                $entityManager->persist($genre);
                $entityManager->flush();
            }
            
           
        }
        foreach ($arr_auteur as list($NomPrenom, $sexe, $DateNaissance, $nationalite)) {
            $acteur = new Auteur();
            
            
            $acteur->setNomPrenom($NomPrenom)
                ->setsexe($sexe)
                ->setDateNaissance(\DateTime::CreateFromFormat("d/m/Y",$DateNaissance))
                ->setNationalite($nationalite);
            $errors = $validator->validate($acteur);
            if (count($errors) == 0) {
                $entityManager->persist($acteur);
                $entityManager->flush();
            }
        }

        foreach ($arr_livre as list($titre, $isbn , $nbpages, $dateparution, $note, $livregenre, $livreauteur)) {
            $livre = new Livre();
           
            $livre->setIsbn($isbn)
                ->setTitre($titre)
                ->setNbpages($nbpages)
                ->setdateParution(\DateTime::CreateFromFormat("d/m/Y", $dateparution))
                ->setNote($note);

               
                foreach($livregenre as $g){
                    $genre = $this->getDoctrine()->getRepository(Genre::class)->findOneBy(array("nom" => $g));
                    $livre->addLivreGenre($genre);
            
                }
                
                foreach($livreauteur as $n){
                    $auteur = $this->getDoctrine()->getRepository(Auteur::class)->findOneBy(array("NomPrenom" => $n));
                    $livre->addLivreAuteur($auteur);
                }
                    
            
            
            $errors = $validator->validate($livre);
            if (count($errors) == 0) {
                $entityManager->persist($livre);
                $entityManager->flush();
            }
        }



        return $this->redirectToRoute("accueil");
    }
    
}
