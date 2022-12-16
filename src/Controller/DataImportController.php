<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\FicheFrais;
use App\Entity\LigneFraisForfaitise;
use App\Entity\LigneFraisHorsForfait;
use App\Entity\TypeFraisForfait;
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
            $newFicheFrais->setNbrJustificatif($ficheFrais->nbJustificatifs);
            $newFicheFrais->setMontantValide($ficheFrais->montantValide);
            $newFicheFrais->setDateDerniereModif(new \DateTime($ficheFrais->dateModif));
            $newFicheFrais->setUser($user);
            switch ($ficheFrais -> idEtat){
                case 'CL':
                    $etat=$doctrine->getRepository(Etat::class)->find(1);
                    break;
                case 'CR':
                    $etat=$doctrine->getRepository(Etat::class)->find(2);
                    break;
                case 'RB':
                    $etat=$doctrine->getRepository(Etat::class)->find(3);
                    break;
                case 'VA':
                    $etat=$doctrine->getRepository(Etat::class)->find(4);
            }
            $newFicheFrais->setEtat($etat);
            $doctrine->getManager()->persist($newFicheFrais);//persist the object $user in the database
            $doctrine->getManager()->flush(); // flush is called to persist it
        }

        return $this->render('data_import/index.html.twig', [
            'controller_name' => 'DataImportController',
        ]);
    }

    #[Route('/dataimporttypefraisforfait', name: 'app_data_typefraisforfait')]
    public function typeFraisForfait(ManagerRegistry $doctrine): Response
    {
        $path="./fraisforfait.json";
        $file=file_get_contents($path);
        $typesFraisForfait = json_decode($file);
        foreach ($typesFraisForfait as $typeFraisForfait){
            $newTypeFraisForfait=new TypeFraisForfait();
            $newTypeFraisForfait->setLibelle($typeFraisForfait->libelle);
            $newTypeFraisForfait->setMontant($typeFraisForfait->montant);
            $doctrine->getManager()->persist($newTypeFraisForfait);//persist the object $user in the database
            $doctrine->getManager()->flush(); // flush is called to persist it
        }

        return $this->render('data_import/index.html.twig', [
            'controller_name' => 'DataImportController',
        ]);
    }

    #[Route('/dataimportlignefraisforfait', name: 'app_data_ligneFraisForfait')]
    public function ligneFraisForfait(ManagerRegistry $doctrine): Response
    {
        $path="./lignefraisforfait.json";
        $file=file_get_contents($path);
        $lignesFraisForfait = json_decode($file);
        foreach ($lignesFraisForfait as $ligneFraisForfait){
           $newLigneFraisForfait= new LigneFraisForfaitise();
           $user=$doctrine->getRepository(User::class)->findOneBy(['oldId'=>$ligneFraisForfait->idVisiteur]);
           $ficheFrais=$doctrine->getRepository(FicheFrais::class)->findOneBy(['user' => $user, 'mois'=>$ligneFraisForfait->mois]);
           $newLigneFraisForfait->setQuantite($ligneFraisForfait->quantite);
            switch($ligneFraisForfait->idFraisForfait) {
                case'ETP':
                    $type = $doctrine->getRepository(TypeFraisForfait::class)->find(1);
                    break;
                case 'KM':
                    $type = $doctrine->getRepository(TypeFraisForfait::class)->find(2);
                    break;
                case'NUI':
                    $type = $doctrine->getRepository(TypeFraisForfait::class)->find(3);
                    break;
                case'REP':
                    $type = $doctrine->getRepository(TypeFraisForfait::class)->find(4);
                    break;

            }
            $newLigneFraisForfait->setTypeFraisForfait($type);
            $newLigneFraisForfait->setFicheFrais($ficheFrais);
            $doctrine->getManager()->persist($newLigneFraisForfait);//persist the object $user in the database
            $doctrine->getManager()->flush(); // flush is called to persist it
        }

        return $this->render('data_import/index.html.twig', [
            'controller_name' => 'DataImportController',
        ]);
    }

    #[Route('/dataimportligneFraisHorsForfait', name: 'app_data_ligneFraisHorsForfait')]
    public function ligneFraisHorsForfait(ManagerRegistry $doctrine): Response
    {
        $path="./lignefraishorsforfait.json";
        $file=file_get_contents($path);
        $lignesFraisHorsForfait = json_decode($file);
        foreach ($lignesFraisHorsForfait as $ligneFraisHorsForfait){
            $newLigneFraisHorsForfait= new LigneFraisHorsForfait();
            $newLigneFraisHorsForfait->setDate(new \DateTime($ligneFraisHorsForfait->date));
            $newLigneFraisHorsForfait->setMontant($ligneFraisHorsForfait->montant);
            $newLigneFraisHorsForfait->setLibelle($ligneFraisHorsForfait->libelle);
            $user=$doctrine->getRepository(User::class)->findOneBy(['oldId'=>$ligneFraisHorsForfait->idVisiteur]);
            $ficheFrais=$doctrine->getRepository(FicheFrais::class)->findOneBy(['user' => $user, 'mois'=>$ligneFraisHorsForfait->mois]);
            $newLigneFraisHorsForfait->setFichefrais($ficheFrais);
            $doctrine->getManager()->persist($newLigneFraisHorsForfait);//persist the object $user in the database
            $doctrine->getManager()->flush(); // flush is called to persist it
        }

        return $this->render('data_import/index.html.twig', [
            'controller_name' => 'DataImportController',
        ]);
    }
}


