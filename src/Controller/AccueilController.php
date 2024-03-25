<?php

namespace App\Controller;

// repositories
use App\Form\JeuRechercheType;
use App\Repository\JeuRepository;
use App\Repository\GenreRepository;
use App\Repository\ConsoleRepository;

use App\Repository\EditeurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(GenreRepository $gRep, JeuRepository $jRep, ConsoleRepository $cRep, EditeurRepository $eRep, Request $r): Response
    {
        $genres   = $gRep->findAll();
        $cptJeux  = count($jRep->findAll());
        $cptCons  = count($cRep->findAll());
        $cptEdit  = count($eRep->findAll());

        $form = $this->createForm(JeuRechercheType::class);
        $form->handleRequest($r);

        if ($form->isSubmitted() && $form->isValid()) {
            $titre = $form->get('titre')->getData();
            return $this->redirect($this->generateUrl('app_jeu').'?'.$r->getQueryString());
        }

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'formJeu' => $form->createView(),
            'genres' => $genres,
            'cptJeux' => $cptJeux,
            'cptCons' => $cptCons,
            'cptEdit' => $cptEdit,
        ]);
    }
}
