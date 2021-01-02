<?php

namespace App\Form;

use App\Form\MediaType;
use App\Entity\References;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ReferenceType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration("Intitulé de votre poste", "Entrez l'intitulé de votre poste..."))
            ->add('company', TextType::class, $this->getConfiguration("Nom de l'entreprise", "Entrez le nom de l'entreprise..."))
            ->add('description', TextareaType::class, $this->getConfiguration("Description de l'expérience pro", "Entrez la description de votre expérience..."))
            ->add('startedAt', DateType::class, $this->getConfiguration("Début", false, [
                "input" => "datetime_immutable",
                "widget" => "single_text"
            ]))
            ->add('endedAt', DateType::class, $this->getConfiguration("Fin", false, [
                "input" => "datetime_immutable",
                "widget" => "single_text",
                "required" => false
            ]))
            ->add("medias", CollectionType::class, [
                "entry_type" => MediaType::class,
                "entry_options" => [
                    "label" => false,
                ],
                "allow_add" => true,
                "allow_delete" => true,
                "by_reference" => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => References::class,
        ]);
    }
}