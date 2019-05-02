<?php

namespace App\Form;

use App\Entity\Support;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SupportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity')
            ->add('name')
            ->add('description')
            ->add('type', ChoiceType::class,
                [
                    'choices'  => $this->getTypeChoices()
                ])
            ->add('barcode')
            ->add('grammage', ChoiceType::class,
                [
                    'choices'  => $this->getGrammageChoices()
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Support::class,
        ]);
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
}
