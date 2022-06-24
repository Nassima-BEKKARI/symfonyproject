<?php

namespace App\Controller;

use DateTime;
use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    public function allArticles(ManagerRegistry $doctrine): Response
    {
        $articles = $doctrine->getRepository(Article::class)->findAll();
        // dd($articles);
        return $this->render('article/allArticles.html.twig', [
            'controller_name' => 'ArticleController',
            'articles' => $articles
        ]);
    }

    public function ajout(ManagerRegistry $doctrine, Request $request )
    {
        // On crée un objet article
        $article = new Article();
        // On crée le formulaire en liant le FormType à l'objet
        $form = $this-> createform(ArticleType::class, $article);
        // On donne accès aux données du formulaire pour la validation des données
        $form->handleRequest($request);
        // si le formulaire est soumis et validé
        if($form->isSubmitted() && $form->isValid())
        {
            // je m'occupe d'affecter les données manquantes (qui ne parviennent pas du formulaire)
            $article->setDateDeCreation(new DateTime("now"));
            // on récupère le manager de doctrine
            $manager = $doctrine->getManager();
            // On persiste l'objet
            $manager->persist($article);
            // puis on envoi en bdd
            $manager->flush();
            return $this->redirectToRoute("app_articles");
        }
        return $this-> render('article/formulaire.html.twig', [
            'formArticle' => $form-> createView()
        ]);
    }

    public function update(managerRegistry $doctrine, Request $request, $id){
        //On récupère l'article à modifier
        $article = $doctrine->getRepository(Article::class)->find($id);
        // On crée le formulaire en liant le FormType à l'objet
        $form = $this-> createform(ArticleType::class, $article);
        // On donne accès aux données du formulaire pour la validation des données
        $form->handleRequest($request);
        // si le formulaire est soumis et validé
        if($form->isSubmitted() && $form->isValid())
        {
            // je m'occupe d'affecter les données manquantes (qui ne parviennent pas du formulaire)
            $article->setDateDeModification(new DateTime("now"));
            // on récupère le manager de doctrine
            $manager = $doctrine->getManager();
            // On persiste l'objet
            $manager->persist($article);
            // puis on envoi en bdd
            $manager->flush();
            return $this->redirectToRoute("app_articles");
        }
        return $this-> render('article/formulaire.html.twig', [
            'formArticle' => $form-> createView()
        ]);
    }

    public function delete(managerRegistry $doctrine, $id){
        // On récupère l'article à supprimer
        $article= $doctrine->getRepository(Article::class)->find($id);
        // On récupère le manager de doctrine
        $manager= $doctrine->getManager();
        // On prépafre l'action de suppréssion
        $manager->remove($article);
        // On exécute la suppression
        $manager->flush();

        return $this->redirectToRoute("app_articles");
    }

    public function select(managerRegistry $doctrine, $id){
        // On récupère l'article à afficher
        $article= $doctrine->getRepository(Article::class)->find($id);
        // dd($article);
         return $this-> render('article/article.html.twig', [
            'article' => $article
        ]);
    }
    
}
