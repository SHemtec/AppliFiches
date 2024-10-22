<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Intervention;
use App\Form\ImportType;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImportController extends AbstractController
{

    #[Route('/import', name: 'app_import')]
    public function import(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ImportType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $files = $form->get('files')->getData();

            foreach ($files as $file) {
                $spreadsheet = IOFactory::load($file->getPathname());
                $worksheet = $spreadsheet->getActiveSheet();

                foreach ($worksheet->getRowIterator() as $row) {
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false);

                    $data = [];
                    foreach ($cellIterator as $cell) {
                        $data[] = $cell->getValue();
                    }

                    // Assuming the data array contains the necessary information
                    $client = new Client();
                    $client->setName($data[0]);
                    $client->setTel($data[1]);

                    $intervention = new Intervention();
                    $intervention->setClient($client);
                    $intervention->setMdpSession($data[2]);
                    $intervention->setProbleme($data[3]);
                    $intervention->setOperations($data[4]);
                    $intervention->setCout($data[5]);
                    $intervention->setNettoyage($data[6] === 'Oui');
                    $intervention->setCreatedAt(new \DateTimeImmutable($data[7]));

                    $entityManager->persist($client);
                    $entityManager->persist($intervention);
                }
            }

            $entityManager->flush();

            $this->addFlash('success', 'Fiches importées avec succès.');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('import/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
