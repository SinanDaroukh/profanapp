<?php

namespace App\Form;

use App\Entity\Medium;
use App\Entity\Search;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codebarre', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Code Barre'
                ]
            ])
            ->add('quantitymax', NumberType::class,
                [
                    'required' => false,
                    'attr' => [
                        'placeholder' => 'Quantité'
                    ],
                    'label' => 'Quantité'
                ])
            ->add('type', ChoiceType::class,
                [
                    'required' => false,
                    'attr' => [
                        'placeholder' => 'Type'
                    ],
                    'choices'  => $this->getTypeChoices()
                ])
            ->add('localisation', ChoiceType::class,
                ['required' => false,
                    'attr' => [
                        'placeholder' => 'Localisation'
                    ],
                    'choices'  => $this->getLocalisationChoices()
                ])
            ->add('nom', TextType::class,
                ['required' => false,
                    'attr' => [
                        'placeholder' => 'Nom'
                    ]
                ])
        ;
    }

    private function getTypeChoices()
    {
        $choices = Medium::TYPE;
        $output = [];
        foreach ($choices as $k => $v){
            $output[$v] = $k+1;
        }
        return $output;
    }

    private function getLocalisationChoices()
    {
        $choices = Medium::LOCALISATION;
        $output = [];
        foreach ($choices as $k => $v){
            $output[$v] = $k+1;
        }
        return $output;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'get',
            'csrf_protection' => false,

        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
