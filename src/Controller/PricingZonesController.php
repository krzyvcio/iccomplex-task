<?php
declare(strict_types=1);

namespace App\Controller;

use App\Repository\ZoneRepository;
use App\Service\CSVService\CSVService;
use App\Service\PricingService\PricingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PricingZonesController extends AbstractController
{

    public function __construct(
        private readonly ZoneRepository $zoneRepository,
        private readonly CSVService     $csvService,
        private readonly PricingService $pricingService
    )
    {
    }

    #[Route('/prices', name: 'getPrices')]
    public function index(): Response
    {

        $zones = $this->zoneRepository->getAllZonesWithShippingCost();

        return $this->render('prices/index.html.twig', [
            'controller_name' => 'PricingZonesController',
            'zones' => $zones,
        ]);
    }


    #[Route('/prices/upload', name: 'uploadZonesShippingCost')]
    public function uploadZonesShippingCost(
        Request $request
    ): Response
    {


        if ($request->isMethod(Request::METHOD_POST)) {
            $file = $request->files->get('csvFile');
            $fileName = $file->getClientOriginalName();

            $errors = $this->csvService->validateFile($file);
            if (count($errors) > 0) {
                return $this->redirectToRoute('prices/upload.html.twig', [
                    'errors' => $errors
                ]);
            }

            $isMimeTypeValid = $this->csvService->validateMimeType($file->getMimeType());
            if ($isMimeTypeValid === false) {
                return $this->redirectToRoute('prices/upload.html.twig', [
                    'errors' => 'Invalid file type'
                ]);
            }

            $zonesShippingCosts = $this->csvService->readFile($file);
            if ($zonesShippingCosts === null) {
                return $this->redirectToRoute('prices/upload.html.twig', [
                    'errors' => 'Error reading file'
                ]);
            }

            $this->pricingService->importZonesShippingCosts($zonesShippingCosts);

            return $this->redirectToRoute('getPrices');


        }

        return $this->render('prices/upload.html.twig', [
            'controller_name' => 'PricingZonesController',
        ]);
    }

}