<?php

namespace App\Form;

use App\Entity\Resume;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ResumeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'required'=>true,
                'label'=>false
            ])

            ->add('photo',FileType::class,[
                'required'=>true,
                'label'=>false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/jpg'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Image',
                    ])
                ],
            ])
            
            ->add('email',EmailType::class,[
                'required'=>true,
                'label'=>false
            ],
            [
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('location',TextType::class,[
                'required'=>true,
                'label'=>false
            ],
            [
                'attr'=>[
                    'class'=>'form-control'
                    ]
            ])
            ->add('profession',TextType::class,[
                'required'=>true,
                'label'=>false,
            ],
            [
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('cv',FileType::class,[
                'required'=>true,
                'label'=>false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ])

            ->add('rate',NumberType::class,[
                'required'=>true,
                'label'=>false,
            ],
            [
                'attr'=>[
                    'class'=>'form-control'
                    ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Resume::class,
        ]);
    }
}
