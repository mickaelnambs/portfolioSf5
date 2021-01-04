<?php

namespace App\Controller\API;

use App\Repository\ReferenceRepository;
use App\Repository\ReferencesRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class ReferenceController.
 * 
 * @Route("/api/references")
 * 
 * @author Mickael Nambinintsoa <mickael.nambinintsoa07081999@gmail.com>
 */
class ReferenceController
{
    /**
     * @Route("", name="api_references_collection_get", methods={"GET"})
     * 
     * @param ReferenceRepository $referenceRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function collection(ReferencesRepository $referenceRepo, SerializerInterface $serializer): JsonResponse
    {
        return new JsonResponse(
            $serializer->serialize($referenceRepo->findAll(), 'json', ['groups' => 'get']),
            200,
            [],
            true
        );
    }
}