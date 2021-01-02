<?php

namespace App\Controller\Admin;

use App\Constant\MessageConstant;
use App\Controller\BaseController;
use App\Entity\References;
use App\Form\ReferenceType;
use App\Repository\ReferencesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ReferenceController.
 * 
 * @Route("/references")
 * 
 * @author Mickael Nambinintsoa <mickael.nambinintsoa07081999@gmail.com>
 */
class ReferenceController extends BaseController
{
    /** @var ReferencesRepository */
    private ReferencesRepository $referenceRepo;

    /**
     * ReferenceController constructor.
     *
     * @param EntityManagerInterface $em
     * @param ReferencesRepository $referenceRepo
     */
    public function __construct(EntityManagerInterface $em, ReferencesRepository $referenceRepo)
    {
        parent::__construct($em);
        $this->referenceRepo = $referenceRepo;
    }

    /**
     * Permet d'avoir les references.
     * 
     * @Route("/", name="reference_manage", methods={"POST","GET"})
     *
     * @return Response
     */
    public function manage(): Response
    {
        return $this->render('back/reference/manage.html.twig', [
            'references' => $this->referenceRepo->findAll()
        ]);
    }

    /**
     * Permet d'ajouter une nouvelle reference.
     * 
     * @Route("/new", name="reference_new", methods={"POST","GET"})
     *
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $reference = new References();
        $form = $this->createForm(ReferenceType::class, $reference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->save($reference)) {
                $this->addFlash(
                    MessageConstant::SUCCESS_TYPE,
                    "La référence a été ajoutée avec succès !"
                );
                return $this->redirectToRoute("reference_manage");
            }
        }
        return $this->render('back/reference/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de modifier une reference.
     * 
     * @Route("/{id}/edit", name="reference_edit", methods={"POST","GET"})
     *
     * @param References $reference
     * @param Request $request
     * @return Response
     */
    public function edit(References $reference, Request $request): Response
    {
        $form = $this->createForm(ReferenceType::class, $reference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->save($reference)) {
                $this->addFlash(
                    MessageConstant::SUCCESS_TYPE,
                    "La référence a été modifiée avec succès !"
                );
                return $this->redirectToRoute("reference_manage");
            }
        }
        return $this->render('back/reference/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de supprimer une reference.
     * 
     * @Route("/{id}/delete", name="reference_delete")
     *
     * @param References $reference
     * @return Response
     */
    public function delete(References $reference): Response
    {
        if ($this->remove($reference)) {
            $this->addFlash(
                MessageConstant::SUCCESS_TYPE,
                "La référence a été supprimée avec succès !"
            );
        }
        return $this->redirectToRoute("reference_manage");
    }
}