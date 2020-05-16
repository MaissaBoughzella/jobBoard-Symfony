<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\TypeJob;
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
class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('username', TextType::class,[ 'label'=>false],array('attr' => array('class' => 'form-control')))
        ->add('email', EmailType::class, [ 'label'=>false],array('attr' => array('class' => 'form-control')))
        ->add('phone', TextType::class, [ 'label'=>false],array('attr' => array('class' => 'form-control')))
        ->add('location', TextType::class,[ 'label'=>false], array('attr' => array('class' => 'form-control')))
        ->add('prof', TextType::class, [ 'label'=>false],array('attr' => array('class' => 'form-control')))
        ->add('education', TextareaType::class,[ 'label'=>false], array('attr' => array('class' => 'form-control')))
        ->add('experience', TextareaType::class, [ 'label'=>false], array('attr' => array('class' => 'form-control')))
        ->add('comp1', TextType::class,[ 'label'=>false], array('attr' => array('class' => 'form-control')))
        ->add('comp2', TextType::class,[ 'label'=>false], array('attr' => array('class' => 'form-control')))
        ->add('comp3', TextType::class,[ 'label'=>false], array('attr' => array('class' => 'form-control')))
        ->add('comp4', TextType::class,[ 'label'=>false], array('attr' => array('class' => 'form-control')))
        ->add('salary', NumberType::class,['label'=>false], array('attr' => array('class' => 'form-control')))
        ->add('password', PasswordType::class,['label'=>false], array('attr' => array('class' => 'form-control')))
        ->add('type',EntityType::class,[
          'label'=>false,
          'required'=>false,
          'class'=> TypeJob::class,
        ])
        ->add('save', SubmitType::class, array(
          'label' => 'Save changes',
         // 'attr' => array('class' => 'site-button')
      ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
