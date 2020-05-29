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
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Category;
class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,['label'=>false,'attr'=>['class'=>'form-control']])
            ->add('username', TextType::class,['label'=>false,'attr'=>['class'=>'form-control']])
            ->add('location', TextType::class,['label'=>false,'attr'=>['class'=>'form-control']])
            ->add('phone', TextType::class,['label'=>false,'attr'=>['class'=>'form-control']])
            ->add('category',EntityType::class,[
                'label'=>false,
                'required'=>false,
                'class'=> Category::class,
                'choice_label' => 'name',
                'multiple'=> false,

            ])
            ->add('roles', CollectionType::class, [
                'entry_type'   => ChoiceType::class,
                'entry_options'  => [
                    'label' => false,
                    'choices' => [
                        '' => '',
                        'Employee' => 'ROLE_EMPLOYEE',
                        'Company' => 'ROLE_COMPANY',
                    ],
                ],
                
      ])
      ->add('image', HiddenType::class, [
        'data' => 'profile.jpg',

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