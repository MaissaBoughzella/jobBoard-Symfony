<?php
// src/FormUserType.php
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,['attr'=>['class'=>'form-control']])
            ->add('username', TextType::class,['attr'=>['class'=>'form-control']])
            ->add('location', TextType::class,['attr'=>['class'=>'form-control']])
            ->add('phone', TextType::class,['attr'=>['class'=>'form-control']])
            ->add('roles', CollectionType::class, [
                'entry_type'   => ChoiceType::class,
                'entry_options'  => [
                    'label' => false,
                    'choices' => [
                        '' => '',
                        'Admin' => 'ROLE_ADMIN',
                        'Employee' => 'ROLE_EMPLOYEE',
                        'Company' => 'ROLE_COMPANY',
                    ],
                ],
                
      ])
                
                
            
        
            ->add('password',PasswordType::class,['attr'=>['class'=>'form-control']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}