<?php

namespace App\Controller\API;

use App\Repository\SkillsRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class SkillController.
 * 
 * @Route("/api/skills")
 * 
 * @author Mickael Nambinintsoa <mickael.nambinintsoa07081999@gmail.com>
 */
class SkillController extends AbstractController
{
    /**
     * @Route("", name="api_skills_collection_get", methods={"GET"})
     *
     * @param SkillsRepository $skillsRepo
     * @return JsonResponse
     */
    public function collection(SkillsRepository $skillsRepo): JsonResponse
    {
        return $this->json($skillsRepo->findAll());
    }
}