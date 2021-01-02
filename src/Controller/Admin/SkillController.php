<?php

namespace App\Controller\Admin;

use App\Constant\MessageConstant;
use App\Controller\BaseController;
use App\Entity\Skills;
use App\Form\SkillType;
use App\Repository\SkillsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SkillController.
 * 
 * @Route("/skills")
 * 
 * @author Mickael Nambinintsoa <mickael.nambinintsoa07081999@gmail.com>
 */
class SkillController extends BaseController
{
    /** @var SkillsRepository */
    private SkillsRepository $skillRepo;

    /**
     * SkillController constructor.
     *
     * @param EntityManagerInterface $em
     * @param SkillsRepository $skillRepo
     */
    public function __construct(EntityManagerInterface $em, SkillsRepository $skillRepo)
    {
        parent::__construct($em);
        $this->skillRepo = $skillRepo;
    }

    /**
     * Permet d'avoir tous les competences.
     * 
     * @Route("/", name="skill_manage", methods={"POST","GET"})
     *
     * @return Response
     */
    public function manage(): Response
    {
        return $this->render('back/skill/manage.html.twig', [
            'skills' => $this->skillRepo->findAll()
        ]);
    }

    /**
     * Permet d'inserer une nouvelle competence.
     * 
     * @Route("/new", name="skill_new", methods={"POST","GET"})
     *
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $skill = new Skills();
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->save($skill)) {
                $this->addFlash(
                    MessageConstant::SUCCESS_TYPE,
                    "La compétence a été ajoutée avec succès !"
                );
                return $this->redirectToRoute("skill_manage");
            }
        }
        return $this->render('back/skill/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de modifier une competence.
     * 
     * @Route("/{id}/edit", name="skill_edit", methods={"POST","GET"})
     *
     * @param Skills $skill
     * @param Request $request
     * @return Response
     */
    public function edit(Skills $skill, Request $request): Response
    {
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->save($skill)) {
                $this->addFlash(
                    MessageConstant::SUCCESS_TYPE,
                    "La compétence a été modifiée avec succès !"
                );
                return $this->redirectToRoute("skill_manage");
            }
        }
        return $this->render('back/skill/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de supprimer une competence.
     * 
     * @Route("/{id}/delete", name="skill_delete")
     *
     * @param Skills $skill
     * @return Response
     */
    public function delete(Skills $skill): Response
    {
        if ($this->remove($skill)) {
            $this->addFlash(
                MessageConstant::SUCCESS_TYPE,
                "La compétence a été supprimée avec succès !"
            );
        }
        return $this->redirectToRoute("skill_manage");
    }
}
