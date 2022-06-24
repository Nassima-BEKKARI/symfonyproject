<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Form\AuteurType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuteurController extends AbstractController
{
    public function add(ManagerRegistry $doctrine, Request $request){
        $auteur = new Auteur();
        $form = $this-> createform(AuteurType::class, $auteur);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager = $doctrine->getManager();
            $manager->persist($auteur);
            $manager->flush();
            return $this->redirectToRoute("app_auteurs");
        }
        return $this-> render('auteur/formulaire.html.twig', [
            'formAuteur' => $form-> createView()
        ]);
    }

    public function allAuteurs(ManagerRegistry $doctrine): Response
    {   
        $auteurs = $doctrine->getRepository(Auteur::class)->findAll();
        return $this->render('auteur/allAuteurs.html.twig', [
            'controller_name' => 'AuteurController',
            'auteurs'=> $auteurs
        ]);
    }

    public function select(ManagerRegistry $doctrine, $id){
        $auteur=$doctrine->getRepository(Auteur::class)->find($id);
        return $this->render('auteur/auteur.html.twig', [
            'controller_name' => 'AuteurController',
            'auteur'=> $auteur
        ]);
    }

    public function update(managerRegistry $doctrine, Request $request, $id){
        $auteur = $doctrine->getRepository(Auteur::class)->find($id);
        $form = $this-> createform(AuteurType::class, $auteur);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager = $doctrine->getManager();
            $manager->persist($auteur);
            $manager->flush();
            return $this->redirectToRoute("app_auteurs");
        }
        return $this-> render('auteur/formulaire.html.twig', [
            'formAuteur' => $form-> createView()
        ]);
    }

    public function delete(ManagerRegistry $doctrine, $id){
        $auteur = $doctrine->getRepository(Auteur::class)->find($id);
        $manager= $doctrine->getManager();
        $manager->remove($auteur);
        $manager->flush();
        return $this->redirectToRoute("app_auteurs");
    }

}
