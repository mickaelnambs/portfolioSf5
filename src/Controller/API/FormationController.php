<?php

namespace App\Controller\API;

use App\Repository\FormationsRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class FormationController.
 * 
 * @Route("/api/formations")
 * 
 * @author Mickael Nambinintsoa <mickael.nambinintsoa07081999@gmail.com>
 */
class FormationController extends AbstractController
{
    /**
     * @Route("", name="api_formations_collection_get", methods={"GET"})
     *
     * @param FormationsRepository $formationRepo
     * @return JsonResponse
     */
    public function collection(FormationsRepository $formationRepo): JsonResponse
    {
        return $this->json($formationRepo->findAll());
    }
}