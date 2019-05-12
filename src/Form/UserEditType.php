<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('roles')
            ->add('firstName', TextType::class)
            ->add('roles', ChoiceType::class , [
            'choices' => [
                'Standard rights' => [
                    'Standard user' => null,
                ],
                'Some administrations rights' => [
                    'Allowed to create users' => 'ROLE_USER_ADMIN',
                    'Allowed to modify products' => 'ROLE_DATA_ADMIN',
                ],
                'All rights' => [
                    'Master Administrator' => 'ROLE_ADMIN'
                ],

            ],
            'multiple' => true,
            'expanded' => true,

        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
