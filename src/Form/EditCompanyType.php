<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class EditCompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('username', TextType::class,[ 'label'=>false],array('attr' => array('class' => 'form-control')))
        ->add('email', EmailType::class, [ 'label'=>false],array('attr' => array('class' => 'form-control')))
        ->add('phone', TextType::class, [ 'label'=>false],array('attr' => array('class' => 'form-control')))
        ->add('description', TextareaType::class,[ 'label'=>false], array('attr' => array('class' => 'form-control')))
        ->add('password', PasswordType::class,['label'=>false], array('attr' => array('class' => 'form-control')))
        ->add('location', TextType::class,[ 'label'=>false], array('attr' => array('class' => 'form-control')))
        ->add('save', SubmitType::class, array(
            'label' => 'Save changes'
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
