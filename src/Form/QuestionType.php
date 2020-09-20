<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\Answer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('promoted',ChoiceType::class, [
                'choices' => [
                    true,
                    false
                ]
            ])
            ->add('status', TextType::class)
            ->add('answers', CollectionType::class, [
                'allow_add' => true,
                'by_reference' => false,
                'entry_type' => AnswerType::class
            ]) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Question::class
            ]
        );
    }
}