<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Intervention;
use App\Form\ImportType;
use App\Repository\InterventionRepository;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(Request $request, ClientRepository $clientRepository, InterventionRepository $interventionRepository, EntityManagerInterface $entityManager): Response
    {
        // Fetch ongoing interventions
        $ongoingInterventions = $interventionRepository->findBy(['statut' => 1]);

        // Fetch statistics
        $clientCount = $clientRepository->count([]);
        $interventionCount = $interventionRepository->count([]);
        $closedInterventionCount = $interventionRepository->count(['statut' => 2]);

        // Import de fichiers xls
        $form = $this->createForm(ImportType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $files = $form->get('files')->getData();
            $flashCounter = 1;
            $format = "";

            foreach ($files as $file) {
                $spreadsheet = IOFactory::load($file->getPathname());
                $worksheet = $spreadsheet->getActiveSheet();

                // Determine the format based on the value of A13
                $isFormat2 = $worksheet->getCell('A17')->getValue() === 'Intervention';

                if ($isFormat2) {
                    // Handle second format
                    $data = [
                        'Nom' => $worksheet->getCell('B1')->getValue(),
                        'Tel' => $worksheet->getCell('B3')->getValue(),
                        'Email' => $worksheet->getCell('B5')->getValue() ?? '', // Valeur par défaut si null
                        'Materiel' => $worksheet->getCell('B7')->getValue(),
                        'Mdp session' => $worksheet->getCell('B9')->getValue() ?? '', // Valeur par défaut si null
                        'Date' => $worksheet->getCell('B11')->getValue(),
                        'Problème' => $worksheet->getCell('B13')->getValue(),
                        'Intervention' => $worksheet->getCell('B17')->getValue() ?? '',
                        'PRIX' => $worksheet->getCell('F19')->getValue() ?? 0, // Valeur par défaut si null
                    ];
                    $format = "2";
                } else {
                    // Handle first format
                    $data = [
                        'Nom' => $worksheet->getCell('B1')->getValue(),
                        'Tel' => $worksheet->getCell('B3')->getValue(),
                        'Email' => $worksheet->getCell('B4')->getValue() ?? '', // Valeur par défaut si null
                        'Materiel' => $worksheet->getCell('B6')->getValue(),
                        'Mdp session' => $worksheet->getCell('B10')->getValue() ?? '', // Valeur par défaut si null
                        'Date' => $worksheet->getCell('B11')->getValue(),
                        'Problème' => $worksheet->getCell('A13')->getValue(),
                        'Intervention' => $worksheet->getCell('A20')->getValue() ?? '',
                        'PRIX' => $worksheet->getCell('F26')->getValue() ?? 0, // Valeur par défaut si null
                    ];
                    $format = "1";
                }

                // Validation des données utiles
                if (isset($data['Nom'], $data['Tel'], $data['Materiel'], $data['Mdp session'], $data['Date'], $data['Problème'])) {

                    // Gestion de la conversion des dates Excel en objets DateTime
                    $excelDate = $data['Date'];
                    $createdAt = null;
                    if (is_numeric($excelDate)) {
                        // Convertir la date Excel en DateTime
                        $dateTime = Date::excelToDateTimeObject($excelDate);

                        // Convertir en DateTimeImmutable
                        $createdAt = \DateTimeImmutable::createFromMutable($dateTime);
                    } else {
                        // Créer un objet DateTimeImmutable directement
                        $createdAt = \DateTimeImmutable::createFromFormat('d/m/Y', $excelDate);
                    }

                    if ($createdAt === false) {
                        $this->addFlash('error', $flashCounter . '. Format de date invalide : ' . $data['Date']);
                        continue;
                    }

                    // Check if client already exists
                    $existingClient = $clientRepository->findOneBy(['name' => $data['Nom'], 'Tel' => $data['Tel']]);
                    if ($existingClient) {
                        $client = $existingClient;
                        $this->addFlash('warning', $flashCounter . '. Client déjà existant : ' . $data['Nom'] . ' - ' . $data['Tel']);
                    } else {
                        $client = new Client();
                        $client->setName($data['Nom']);
                        $client->setTel($data['Tel']);
                        $client->setEmail($data['Email']); // Champ email optionnel
                        $client->setCreatedAt($createdAt);
                        $entityManager->persist($client);
                        $entityManager->flush();
                    }

                    // Check if intervention already exists
                    $existingIntervention = $interventionRepository->findOneBy([
                        'client' => $client,
                        'Materiel' => $data['Materiel'],
                        'MdpSession' => $data['Mdp session'],
                        'createdAt' => $createdAt,
                    ]);

                    if ($existingIntervention) {
                        $this->addFlash('warning', $flashCounter . '. Intervention déjà existante pour le client : ' . $data['Nom']);
                    } else {
                        $intervention = new Intervention();
                        $intervention->setClient($client);
                        $intervention->setMateriel($data['Materiel']);
                        $intervention->setMdpSession($data['Mdp session']);
                        $intervention->setProbleme($data['Problème']);
                        $intervention->setOperations($data['Intervention']);
                        $intervention->setCout($data['PRIX']);
                        $intervention->setCreatedAt($createdAt);
                        $intervention->setStatut(2); // Closed status
                        $intervention->setFinishedAt($createdAt); // Closure date = creation date

                        $entityManager->persist($intervention);
                        $this->addFlash('success', $flashCounter . '. FORMAT: '. $format .' Ligne importée avec succès.');
                    }
                } else {
                    $this->addFlash('error', $flashCounter . '. FORMAT: '. $format .' Données manquantes ou incorrectes dans le fichier XLSX : ' . json_encode($data));
                }

                $flashCounter++;
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_main');
        }

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'ongoingInterventions' => $ongoingInterventions,
            'clientCount' => $clientCount,
            'interventionCount' => $interventionCount,
            'closedInterventionCount' => $closedInterventionCount,
        ]);
    }
}