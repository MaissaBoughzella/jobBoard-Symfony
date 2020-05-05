<?php

namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\Category;
use App\Entity\Company;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Data\SearchData;

class SearchCompany extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder,array $options)
    {

        $builder
            ->add('q',TextType::class,[
                'label'=>false,
                'required'=>false,
                'attr'=>[
                    'placeholder'=>'Search',
                    'class' => 'form-control', 
                   
                ]
            ])
            ->add('l',TextType::class,[
                'label'=>false,
                'required'=>false,
                'attr'=>[
                    'placeholder'=>'Location',
                    'class' => 'form-control', 
                   
                ]
            ])
            ->add('categories',EntityType::class,[
                'label'=>false,
                'required'=>false,
                'class'=> Category::class,
                'choice_label' => 'name',
                'multiple'=> true,

            ])
            ->add('filter', SubmitType::class, array(
                'label' => 'Filter',
                'attr'=>array('style' => 'margin-top:10%;width:100%','class' => 'site-button'),
                //'attr' => array('class' => 'site-button')
            ))
            
            ;
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
