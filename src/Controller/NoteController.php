<?php

namespace App\Controller;

use App\Entity\Note;
use App\Form\NoteType;
use App\Entity\Matiere;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Contracts\Translation\TranslatorInterface;


class NoteController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function index( ManagerRegistry $doctrine, Request $request,TranslatorInterface $translator): Response
    {
        $note = new Note();
        $form = $this->createForm(NoteType::class, $note);

        $form->handleRequest($request);

       // Récupération de la connexion à la BDD
       $entityManager = $doctrine->getManager();
       
       if($form->isSubmitted() && $form->isValid()){
            $date = new \DateTime("now", new \DateTimeZone('Europe/Paris'));;
            $note->setCreatedAt($date);

           $entityManager->persist($note);
           $entityManager->flush();
    
           $this->addFlash('success', $translator->trans('note.sucess.add'));
           return $this->redirectToRoute('accueil');
       }

        $notes = $entityManager->getRepository(Note::class)->findAll();
        $matieres = $entityManager->getRepository(Matiere::class)->findAll();
       
        return $this->render('note/index.html.twig', [
            'notes' => $notes,
            'matieres'=>$matieres,
            'ajout'=>$form->createView(),
            
        ]);
    }
}
