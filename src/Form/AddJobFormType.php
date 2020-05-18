<?php

namespace App\Form;

use App\Entity\Job;
use App\Entity\TypeJob;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AddJobFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[ 'label'=>false],array('attr' => array('class' => 'form-control')))
            ->add('location',TextType::class,[ 'label'=>false],array('attr' => array('class' => 'form-control')))
            ->add('wage',NumberType::class,[ 'label'=>false],array('attr' => array('class' => 'form-control')))
            ->add('experience',TextType::class,[ 'label'=>false],array('attr' => array('class' => 'form-control')))
            ->add('offre',TextType::class,[ 'label'=>false],array('attr' => array('class' => 'form-control')))
            ->add('description',TextareaType::class,[ 'label'=>false],array('attr' => array('class' => 'form-control')))
            ->add('req',TextType::class,[ 'label'=>false],array('attr' => array('class' => 'form-control')))
            ->add('req2',TextType::class,[ 'label'=>false],array('attr' => array('class' => 'form-control')))
            ->add('req3',TextType::class,[ 'label'=>false],array('attr' => array('class' => 'form-control')))
            ->add('req4',TextType::class,[ 'label'=>false],array('attr' => array('class' => 'form-control')))
            ->add('category',EntityType::class,[
                'label'=>false,
                'required'=>false,
                'class'=> Category::class,
              ])
            ->add('type',EntityType::class,[
                'label'=>false,
                'required'=>false,
                'class'=> TypeJob::class,
              ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Job::class,
        ]);
    }
}
