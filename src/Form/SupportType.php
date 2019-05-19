<?php

namespace App\Form;

use App\Entity\Support;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SupportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity', NumberType::class)
            ->add('name', TextType::class)
            ->add('imagefile', FileType::class, [
                'required' => false
            ])
            ->add('description', TextareaType::class)
            ->add('type', ChoiceType::class,
                [
                    'choices'  => $this->getChoices(Support::TYPE)
                ])
            ->add('barcode', NumberType::class)
            ->add('localisation', ChoiceType::class,
                [
                    'choices'  => $this->getChoices(Support::LOCALISATION)
                ])
            ->add('grammage', ChoiceType::class,
                [
                    'choices'  => $this->getChoices(Support::GRAMMAGE)
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Support::class,
        ]);
    }

    private function getChoices($array)
    {
        $choices = $array;
        $output = [];
        foreach ($choices as $k => $v){
            $output[$v] = $k+1;
        }
        return $output;
    }
}
