<?php

namespace App\Controller;

use App\Entity\Enseignement;
use App\Form\EnseignementType;
use App\Repository\EnseignementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/enseignement")
 */
class EnseignementController extends AbstractController
{
    /**
     * @Route("/", name="enseignement_index", methods={"GET"})
     */
    public function index(EnseignementRepository $enseignementRepository): Response
    {
        return $this->render('enseignement/index.html.twig', [
            'enseignements' => $enseignementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="enseignement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $enseignement = new Enseignement();
        $form = $this->createForm(EnseignementType::class, $enseignement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($enseignement);
            $entityManager->flush();

            return $this->redirectToRoute('enseignement_index');
        }

        return $this->render('enseignement/new.html.twig', [
            'enseignement' => $enseignement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="enseignement_show", methods={"GET"})
     */
    public function show(Enseignement $enseignement): Response
    {
        return $this->render('enseignement/show.html.twig', [
            'enseignement' => $enseignement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="enseignement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Enseignement $enseignement): Response
    {
        $form = $this->createForm(EnseignementType::class, $enseignement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('enseignement_index');
        }

        return $this->render('enseignement/edit.html.twig', [
            'enseignement' => $enseignement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="enseignement_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Enseignement $enseignement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$enseignement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($enseignement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('enseignement_index');
    }
}
