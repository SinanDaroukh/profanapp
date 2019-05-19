<?php

namespace App\Form;

use App\Entity\Support;
use App\Entity\SupportSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SupportSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('barcode', NumberType::class,
                [
                    'label' => 'Code Barre',
                    'required' => false,
                    'attr' => [
                        'placeholder' => 'Code Barre'
                    ]
            ])
            ->add('type', ChoiceType::class,
                [
                    'required' => false,
                    'attr' => [
                        'placeholder' => 'Type'
                    ],
                    'choices'  => $this->getTypeChoices()
                ])
            ->add('grammage', ChoiceType::class,
                ['required' => false,
                    'attr' => [
                        'placeholder' => 'Grammage'
                    ],
                    'choices'  => $this->getGrammageChoices()
                ])
            ->add('name', TextType::class,
                [
                    'label' => 'Nom',
                    'required' => false,
                    'attr' => [
                        'placeholder' => 'Nom'
                    ]
                ])
            ->add('localisation', ChoiceType::class,
                ['required' => false,
                    'attr' => [
                        'placeholder' => 'Localisation'
                    ],
                    'choices'  => $this->getLocalisationChoices()
                ])
            ->add('quantity', NumberType::class,
                [
                    'label' => 'Quantité',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Quantité'
                    ]
                ])
        ;
    }

    private function getLocalisationChoices()
    {
        $choices = Support::LOCALISATION;
        $output = [];
        foreach ($choices as $k => $v){
            $output[$v] = $k+1;
        }
        return $output;
    }

    private function getTypeChoices()
    {
        $choices = Support::TYPE;
        $output = [];
        foreach ($choices as $k => $v){
            $output[$v] = $k+1;
        }
        return $output;
    }

    private function getGrammageChoices()
    {
        $choices = Support::GRAMMAGE;
        $output = [];
        foreach ($choices as $k => $v){
            $output[$v] = $k+1;
        }
        return $output;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SupportSearch::class,
            'method' => 'get',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
