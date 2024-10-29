<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Intervention;
use App\Entity\Test;
use App\Form\InterventionType;
use App\Form\TestType;
use App\Repository\InterventionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/intervention')]
final class InterventionController extends AbstractController
{
    #[Route('/', name: 'app_intervention_index', methods: ['GET'])]
    public function index(InterventionRepository $interventionRepository): Response
    {
        $interventions = $interventionRepository->findBy([], ['createdAt' => 'DESC']);

        return $this->render('intervention/index.html.twig', [
            'interventions' => $interventions,
        ]);
    }

    #[Route('/new', name: 'app_intervention_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $intervention = new Intervention();
        $form = $this->createForm(InterventionType::class, $intervention);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($intervention);
            $entityManager->flush();

            return $this->redirectToRoute('app_intervention_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('intervention/new.html.twig', [
            'intervention' => $intervention,
            'form' => $form,
        ]);
    }



    #[Route('/{id}', name: 'app_intervention_show', methods: ['GET', 'POST'])]
    public function show(Request $request, Intervention $intervention, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InterventionType::class, $intervention);
        $form->handleRequest($request);

        //recupere les tests de chaque interventions
        $tests = $entityManager->getRepository(Test::class)->findBy(['intervention' => $intervention->getId()]);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_intervention_index', [], Response::HTTP_SEE_OTHER);
        }

        $test = new Test();
        $test->setIntervention($intervention);

        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($test);
            $entityManager->flush();

            return $this->redirectToRoute('app_test_index');
        }


        return $this->render('intervention/show.html.twig', [
            'intervention' => $intervention,
            'tests' => $tests
        ]);
    }

    #[Route('/{id}/edit', name: 'app_intervention_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Intervention $intervention, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InterventionType::class, $intervention);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_intervention_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('intervention/edit.html.twig', [
            'intervention' => $intervention,
            'form' => $form,
        ]);
    }

    #[Route('/del/{id}', name: 'app_intervention_delete', methods: ['POST'])]
    public function delete(Request $request, Intervention $intervention, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$intervention->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($intervention);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_intervention_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/new/{clientId}', name: 'app_intervention_newFromClient', methods: ['GET', 'POST'])]
    public function newFromClient(Request $request, EntityManagerInterface $entityManager, int $clientId): Response
    {
        $client = $entityManager->getRepository(Client::class)->find($clientId);
        $intervention = new Intervention();
        $intervention->setClient($client);
        $form = $this->createForm(InterventionType::class, $intervention, ['client' => $client]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($intervention);
            $entityManager->flush();

            return $this->redirectToRoute('app_client_show', ['id' => $client->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('intervention/_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/close/{id}', name: 'app_intervention_close', methods: ['POST'])]
    public function close(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $intervention = $entityManager->getRepository(Intervention::class)->find($id);

        if (!$intervention) {
            throw $this->createNotFoundException('No intervention found for id ' . $id);
        }

        $intervention->setStatut(2); // Set status to "Terminé"
        $intervention->setFinishedAt(new \DateTimeImmutable()); // Set finishedAt to current date

        $entityManager->flush();

        $redirectUrl = $request->request->get('redirect_url', $this->generateUrl('app_intervention_show', ['id' => $id]));

        return $this->redirect($redirectUrl);
    }

    #[Route('/reopen/{id}', name: 'app_intervention_reopen', methods: ['POST'])]
    public function reopen(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $intervention = $entityManager->getRepository(Intervention::class)->find($id);

        if (!$intervention) {
            throw $this->createNotFoundException('No intervention found for id ' . $id);
        }

        $intervention->setStatut(1); // Set status to "Terminé"
        $intervention->setUpdatedAt(new \DateTimeImmutable()); // Set finishedAt to current date

        $entityManager->flush();

        $redirectUrl = $request->request->get('redirect_url', $this->generateUrl('app_intervention_show', ['id' => $id]));

        return $this->redirect($redirectUrl);
    }

    #[Route('/{id}/print', name: 'app_intervention_print', methods: ['GET'])]
    public function print(Intervention $intervention): Response
    {
        return $this->render('intervention/print.html.twig', [
            'intervention' => $intervention,
        ]);
    }
}
