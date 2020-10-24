<?php

namespace App\Form;

use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('NSC',TextType::class,[
                'label'=>"NSC",
                'attr'=>[
                    "placeholder"=>"add NSC",
                    'class'=>"form-control"
                ]
            ])
            ->add('Email',TextType::class,[
                'label'=>"email",
                'attr'=>[
                    "placeholder"=>"add email",
                    'class'=>"form-control"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
