<?php

namespace App\Form\Type;

use App\Entity\PokerHand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PokerTableType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstPlayer', TextType::class, [
                'required' => true
            ])
            ->add('secondPlayer', TextType::class, [
                'required' => true
            ])
            ->add('Compare', SubmitType::class)
        ;
    }

}