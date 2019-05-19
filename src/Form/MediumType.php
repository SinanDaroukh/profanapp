<?php

namespace App\Form;

use App\Entity\Medium;
use App\Entity\Support;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity', NumberType::class)
            ->add('nom', TextType::class)
            ->add('description', TextareaType::class)
            ->add('type', ChoiceType::class,
                [
                    'choices'  => $this->getChoices(Support::TYPE)
                ])
            ->add('codebarre', NumberType::class)
            ->add('localisation', ChoiceType::class,
                [
                    'choices'  => $this->getChoices(Support::LOCALISATION)
                ])
        ;
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

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Medium::class,
        ]);
    }
}
