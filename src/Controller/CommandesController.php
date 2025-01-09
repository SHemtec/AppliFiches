<?php

namespace App\Controller;

use App\Entity\Commandes;
use App\Form\CommandesType;
use App\Repository\CommandesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/commandes')]
final class CommandesController extends AbstractController
{
    #[Route(name: 'app_commandes_index', methods: ['GET', 'POST'])]
    public function index(CommandesRepository $commandesRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $commande = new Commandes();
        $form = $this->createForm(CommandesType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commande);
            $entityManager->flush();
            $this->addFlash('success', 'Commande créée.');

            return $this->redirectToRoute('app_commandes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commandes/index.html.twig', [
            'commandes' => $commandesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_commandes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commande = new Commandes();
        $form = $this->createForm(CommandesType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commande);
            $entityManager->flush();

            return $this->redirectToRoute('app_commandes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commandes/new.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commandes_show', methods: ['GET'])]
    public function show(Commandes $commande): Response
    {
        return $this->render('commandes/show.html.twig', [
            'commande' => $commande,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_commandes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commandes $commande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommandesType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commandes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commandes/edit.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commandes_delete', methods: ['POST'])]
    public function delete(Request $request, Commandes $commande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commandes_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/validate/{id}', name: 'app_commandes_validate')]
    public function validateOrder(Commandes $commande, EntityManagerInterface $entityManager): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $commande->setStatus(true);
        $commande->setOrderedAt(new \DateTimeImmutable());

        $entityManager->persist($commande);
        $entityManager->flush();
        $this->addFlash('success', 'Commande validée.');

        return $this->redirectToRoute('app_commandes_index');
    }

    #[Route('/validate_delivery/{id}', name: 'app_commandes_validate_delivery', methods: ['POST'])]
    public function validateDelivery(Commandes $commande, EntityManagerInterface $entityManager): Response
    {
        $commande->setDeliveryStatus(true);

        $entityManager->persist($commande);
        $entityManager->flush();
        $this->addFlash('success', 'Livraison validée.');

        return $this->redirectToRoute('app_commandes_index');
    }

    #[Route('/validate_call/{id}', name: 'app_commandes_validate_call', methods: ['POST'])]
    public function validateCall(Commandes $commande, EntityManagerInterface $entityManager): Response
    {
        $commande->setClientCalledStatus(true);

        $entityManager->persist($commande);
        $entityManager->flush();
        $this->addFlash('success', 'Appel client validé.');

        return $this->redirectToRoute('app_commandes_index');
    }
}
