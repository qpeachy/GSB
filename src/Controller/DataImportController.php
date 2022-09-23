<?php

namespace App\Controller;

use App\Entity\FicheFrais;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class DataImportController extends AbstractController
{
    #[Route('/dataimport', name: 'app_data_import')]
    public function index(ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher): Response
    {
        $path="./visiteur.json";
        $file=file_get_contents($path);
        $users = json_decode($file);
        foreach ($users as $user){
            $newUser = new User();
            $newUser->setOldId($user->id);
            $newUser->setPrenom($user->prenom);
            $newUser->setNom($user->nom);
            $newUser->setLogin($user->login);
            $newUser->setAdresse($user->adresse);
            $newUser->setVille($user->ville);
            $newUser->setCp($user->cp);
            $newUser->setDateEmbauche(new \DateTime($user->dateEmbauche));
            $plaintextPassword=$user->mdp;
            $hashedpassword=$passwordHasher->hashPassword($newUser, $plaintextPassword);//hash the password
            $newUser->setPassword($hashedpassword); //set the hashed password
            //Persist the created object= save it in the database with the ORM Doctrine
            $doctrine->getManager()->persist($newUser);//persist the object $user in the database
            $doctrine->getManager()->flush(); // flush is called to persist it
        }

        return $this->render('data_import/index.html.twig', [
            'controller_name' => 'DataImportController',
        ]);
    }

    #[Route('/dataimportfichefrais', name: 'app_data_importfichefrais')]
    public function ficheFrais(ManagerRegistry $doctrine): Response
    {
        $path="./fichefrais.json";
        $file=file_get_contents($path);
        $fichesFrais = json_decode($file);
        foreach ($fichesFrais as $ficheFrais){
            $newFicheFrais = new FicheFrais();
            $user=$doctrine->getRepository(User::class)->findOneBy(['oldId'=>$ficheFrais->idVisiteur]);
            $newFicheFrais->setMois($ficheFrais->mois);
            $newFicheFrais->setNbrJusificatif($ficheFrais->nbJustificatifs);
            $newFicheFrais->setMontantValide($ficheFrais->montantValide);
            $newFicheFrais->setDateDerniereModif(new \DateTime($ficheFrais->dateModif));

//            $newFicheFrais->setUser();
//
//
//            $doctrine->getManager()->persist();//persist the object $user in the database
//            $doctrine->getManager()->flush(); // flush is called to persist it
        }

        return $this->render('data_import/index.html.twig', [
            'controller_name' => 'DataImportController',
        ]);
    }
}


