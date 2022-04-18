<?php

namespace App\Controller;

use App\Entity\Matiere;
use App\Form\MatiereType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class MatiereController extends AbstractController
{
    #[Route('/matieres', name: 'matieres')]
    public function index(ManagerRegistry $doctrine, Request $request,TranslatorInterface $translator): Response
    {
         $matiere = new Matiere();

         $form = $this->createForm(MatiereType::class, $matiere);
         $form->handleRequest($request);

        // Récupération de la connexion à la BDD
        $entityManager = $doctrine->getManager();
        
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($matiere);
            $entityManager->flush();
            $this->addFlash('success', $translator->trans('matiere.sucess.add'));
        }

        $matieres = $entityManager->getRepository(Matiere::class)->findAll();
 
        return $this->render('matiere/index.html.twig', [
            'matieres' => $matieres,
            'ajout' => $form->createView()
        ]);
    }

    #[Route('/matiere/{id}', name:'matiere_detail')]

    public function detail(Matiere $matiere = null, ManagerRegistry $doctrine, Request $request, TranslatorInterface $translator){

        if($matiere == null){
            $this->addFlash('danger', $translator->trans('matiere.erreur.introuvable'));
            return $this->redirectToRoute('matieres');
        }

        $form = $this->createForm(MatiereType::class, $matiere);
        $form->handleRequest($request);

         // Récupération de la connexion à la BDD
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $doctrine->getManager();
            $entityManager->persist($matiere);
            $entityManager->flush();

            $this->addFlash('success', $translator->trans('matiere.sucess.maj'));
        }
 
        return $this->render('matiere/detail.html.twig', [
            'matiere' => $matiere,
            'edit' => $form->createView()
        ]);
    }

    #[Route('delete/matiere/{id}', name:'matiere_delete')]
    public function delete(Matiere $matiere = null, ManagerRegistry $doctrine, TranslatorInterface $translator){

        if($matiere == null){
            $this->addFlash('danger', $translator->trans('matiere.erreur.introuvable'));
            return $this->redirectToRoute('matieres');
        }
            $entityManager = $doctrine->getManager();
            $entityManager->remove($matiere);
            $entityManager->flush();

            $this->addFlash('warning', $translator->trans('matiere.sucess.delete'));
        
            return $this->redirectToRoute('matieres');;
    }  
}
