<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class CreateUserController extends AbstractController
{
    #[Route('/createuser', name: 'app_create_user')]
    public function index(ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user= new User();
        $user->setNom('Lamnla');
        $user->setPrenom('Kiera');
        $user->setAdresse('8 rue de la joie');
        $user->setCp('64023');
        $user->setVille('Happy');
        $user->setLogin('Klamnla');
        $user->setDateEmbauche(new \DateTime('2022-09-15'));
        $plaintextPassword='Th3G04t';
        $hashedpassword=$passwordHasher->hashPassword($user, $plaintextPassword);//hash the password
        $user->setPassword($hashedpassword); //set the hashed password
        //Persist the created object= save it in the database with the ORM Doctrine
        $doctrine->getManager()->persist($user);//persist the object $user in the database
        $doctrine->getManager()->flush(); // flush is called to persist it

        //Finally i generate the web page from the template index.html.twig situated in /templates/create_user
        //And i lend the page the variable 'userlogin' that I'll reuse in the template Twig
        //By sliding it in the page html.twig with {{userlogin}}
        return $this->render('create_user/index.html.twig', [
            'controller_name' => 'CreateUserController',
            'user' => $user->getLogin(),
        ]);
    }
}
