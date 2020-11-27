<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                "label" => "Nom"
            ])
            ->add('description', TextareaType::class, [
                "label" => "Description"
            ])
            ->add('dueDate', DateType::class, [
                "label" => "Date de fin",
                'format' => 'dd-M-yyyy',
                "years" => range(date("Y"), (date("Y") + 10))
            ])
            ->add('save', SubmitType::class, [
                'label' => "Enregister",
                "attr" => [
                    "class" => "btn btn-lg secondBg my-3 text-white"
                ],
                'row_attr' => [
                    'class' => 'text-center'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
