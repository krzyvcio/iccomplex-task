<?php

namespace App\Controller;

use App\Data\FormDTO;
use App\Data\ShippinPostDTO;
use App\Service\ShippingService\ShippingService;
use App\Validator\CalculatingFormValidator;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalculationFormController extends AbstractController
{

    public function __construct(
        private readonly CalculatingFormValidator $formValidator,
        private readonly ShippingService          $shippingService
    )
    {
    }

    /**
     * @throws Exception
     */
    #[Route('/calculation', name: 'calculation')]
    public function index(
        Request $request,
    ): Response
    {

        if ($request->isMethod(Request::METHOD_POST)) {

            $dto = new FormDTO(
                $request->request->get('postCode'),
                $request->request->get('totalAmount'),
                $request->request->get('longProduct')
            );

            $validationErrors = $this->formValidator->validate($dto);

            if (count($validationErrors) > 0) {
                return $this->render('form/index.html.twig', [
                    'validationErrors' => $validationErrors,
                    'formDTO' => $dto,
                ]);
            }

            $this->shippingService->calculateAndSave($dto);

            return $this->redirectToRoute('calculation', [
            ]);

        }


        return $this->render('form/index.html.twig', [
            'controller_name' => 'FormController',
            'formDTO' => new FormDTO(null, null, null),

        ]);
    }


}