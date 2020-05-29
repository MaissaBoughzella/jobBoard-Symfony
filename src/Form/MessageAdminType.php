<?php

namespace App\Form;

use App\Entity\MessageAdmin;
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

class MessageAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sendTo',EmailType::class, [ 'label'=>false],array('attr' => array('class' => 'form-control','style'=>'margin-top: -6%;margin-left: 20%;')))
            ->add('subject',TextType::class, [ 'label'=>false],array('attr' => array('class' => 'form-control')))
            ->add('message',TextareaType::class,[ 'label'=>false], array('attr' => array('class' => 'form-control')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MessageAdmin::class,
        ]);
    }
}
