<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('slug')
            ->add('body')
            ->add('category',EntityType::class,[
                'class' => Category::class,
                'choice_label' => 'name',
                'choice_value' => 'id',
                'placeholder' => 'Select Category',
                'expanded' => false,
                'multiple' => false
            ])
            ->add('is_publish')
            // ->add('category')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }

    
}
