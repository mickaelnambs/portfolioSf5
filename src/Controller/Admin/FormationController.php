<?php

namespace App\Controller\Admin;

use App\Constant\MessageConstant;
use App\Controller\BaseController;
use App\Entity\Formations;
use App\Form\FormationType;
use App\Repository\FormationsRepository;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FormationController.
 * 
 * @Route("/admin/formations")
 * 
 * @author Mickael Nambinintsoa <mickael.nambinintsoa07081999@gmail.com>
 */
class FormationController extends BaseController
{
    /** @var FormationsRepository */
    private FormationsRepository $formationRepo;

    /**
     * FormationController constructor.
     *
     * @param EntityManagerInterface $em
     * @param FormationsRepository $formationRepo
     */
    public function __construct(EntityManagerInterface $em, FormationsRepository $formationRepo)
    {
        parent::__construct($em);
        $this->formationRepo = $formationRepo;
    }

    /**
     * Permet d'avoir les formations.
     * 
     * @Route("/{page<\d+>?1}", name="formation_manage", methods={"POST","GET"})
     *
     * @param integer $page
     * @param PaginationService $pagination
     * @return Response
     */
    public function manage(int $page, PaginationService $pagination): Response
    {
        $pagination->setEntityClass(Formations::class)
            ->setLimit(4)
            ->setPage($page);

        return $this->render('back/formation/manage.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * Permet de creer une nouvelle formation.
     * 
     * @Route("/new", name="formation_new", methods={"POST","GET"})
     *
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $formation = new Formations();
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->save($formation)) {
                $this->addFlash(
                    MessageConstant::SUCCESS_TYPE,
                    "La formation a été ajoutée avec succès !"
                );
                return $this->redirectToRoute('formation_manage');
            }
        }
        return $this->render('back/formation/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de modifier une formation.
     * 
     * @Route("/{id}/edit", name="formation_edit", methods={"POST","GET"})
     *
     * @param Formations $formation
     * @param Request $request
     * @return Response
     */
    public function edit(Formations $formation, Request $request): Response
    {
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->save($formation)) {
                $this->addFlash(
                    MessageConstant::SUCCESS_TYPE,
                    "La formation a été modifiée avec succès !"
                );
                return $this->redirectToRoute('formation_manage');
            }
        }
        return $this->render('back/formation/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de supprimer une formation.
     * 
     * @Route("/{id}/delete", name="formation_delete")
     *
     * @param Formations $formation
     * @return Response
     */
    public function delete(Formations $formation): Response
    {
        if ($this->remove($formation)) {
            $this->addFlash(
                MessageConstant::SUCCESS_TYPE,
                "La formation a été modifiée avec succès !"
            );
        }
        return $this->redirectToRoute('formation_manage');
    }
}
