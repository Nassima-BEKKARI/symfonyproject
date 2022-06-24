<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    public function home(ManagerRegistry $doctrine): Response
    {
        $dernierArticlePublie = $doctrine->getRepository(Article::class)->findOneBy([],["dateDeCreation"=>"DESC"]);
        // dd($dernierArticlePublie);
        return $this->render('home/index.html.twig', [
            'dernierArticlePublie' => $dernierArticlePublie
        ]);
    }
}
