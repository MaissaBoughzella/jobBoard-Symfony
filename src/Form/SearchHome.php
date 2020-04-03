<?php

namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\Category;
use App\Entity\TypeJob;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Data\SearchData;
class SearchHome extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder,array $options)
    {

        $builder
            ->add('q',TextType::class,[
                'label'=>false,
                'required'=>false,
                'attr'=>[
                    'placeholder'=>'Enter a Job Title',
                    'class' => 'form-control', 
                    'style' => 'width:450px;'
                ]
            ])
            ->add('l',TextType::class,[
                'label'=>false,
                'required'=>false,
                'attr'=>[
                    'placeholder'=>'Enter a City Or Region',
                    'class' => 'form-control',
                    'style' => 'width:450px;'
                   
                ]
            ]);
    }
    public function configureOptions(OptionsResolver $resolver){
        $resolver->setDefaults([
            'data_class'=> SearchData::class,
            'method'=>'GET',
            'csrf_protection'=>false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }

}
