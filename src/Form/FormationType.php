<?php

namespace App\Form;

use App\Entity\Formations;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class FormationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, $this->getConfiguration("Nom de la formation", "Entrez le nom de votre formation..."))
            ->add('school', TextType::class, $this->getConfiguration("Nom de l'école", "Entrez le nom de l'école..."))
            ->add("gradeLevel", ChoiceType::class, $this->getConfiguration("Niveau d'étude", false, [
                "choices" => [
                    "BAC" => 0,
                    "BAC+1" => 1,
                    "BAC+2" => 2,
                    "BAC+3" => 3,
                    "BAC+4" => 4,
                    "BAC+5" => 5,
                    "BAC+8" => 8
                ]
            ]))
            ->add('description', TextareaType::class, $this->getConfiguration("Description de la formation", "Entrez la description de la formation..."))
            ->add('startedAt', DateType::class, $this->getConfiguration("Début de la formation", false, [
                "input" => "datetime_immutable",
                "widget" => "single_text"
            ]))
            ->add('endedAt', DateType::class, $this->getConfiguration("Fin de la formation", false, [
                "input" => "datetime_immutable",
                "widget" => "single_text",
                "required" => false
            ]));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Formations::class,]);
    }
}