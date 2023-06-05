<?php

namespace App\Controller;

use App\Entity\Torneo;
use App\Form\TorneoType;
use App\Repository\TorneoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/torneo")
 */
class TorneoController extends AbstractController
{
    /**
     * @Route("/", name="app_torneo_index", methods={"GET"})
     */
    public function index(TorneoRepository $torneoRepository): Response
    {
        return $this->render('torneo/index.html.twig', [
            'torneos' => $torneoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_torneo_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TorneoRepository $torneoRepository): Response
    {
        $torneo = new Torneo();
        $form = $this->createForm(TorneoType::class, $torneo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $torneoRepository->add($torneo, true);

            return $this->redirectToRoute('app_torneo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('torneo/new.html.twig', [
            'torneo' => $torneo,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_torneo_show", methods={"GET"})
     */
    public function show(Torneo $torneo): Response
    {
        return $this->render('torneo/show.html.twig', [
            'torneo' => $torneo,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_torneo_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Torneo $torneo, TorneoRepository $torneoRepository): Response
    {
        $form = $this->createForm(TorneoType::class, $torneo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $torneoRepository->add($torneo, true);

            return $this->redirectToRoute('app_torneo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('torneo/edit.html.twig', [
            'torneo' => $torneo,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_torneo_delete", methods={"POST"})
     */
    public function delete(Request $request, Torneo $torneo, TorneoRepository $torneoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$torneo->getId(), $request->request->get('_token'))) {
            $torneoRepository->remove($torneo, true);
        }

        return $this->redirectToRoute('app_torneo_index', [], Response::HTTP_SEE_OTHER);
    }
}
