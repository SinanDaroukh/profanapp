<?php

namespace App\Form;

use App\Entity\Support;
use App\Entity\SupportSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SupportSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('barcode', IntegerType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Barcode'
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
                ['required' => false,
                    'attr' => [
                        'placeholder' => 'Name'
                    ]
                ])
        ;
    }

    private function getTypeChoices()
    {
        $choices = Support::TYPE;
        $output = [];
        foreach ($choices as $k => $v){
            $output[$v] = $k;
        }
        return $output;
    }

    private function getGrammageChoices()
    {
        $choices = Support::GRAMMAGE;
        $output = [];
        foreach ($choices as $k => $v){
            $output[$v] = $k;
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
