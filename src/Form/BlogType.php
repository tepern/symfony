<?php

namespace App\Form;

use App\Entity\Blog;
use App\Entity\Category;
use App\Form\DataTransformer\TagTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BlogType extends AbstractType
{
    public function __construct(
        private readonly TagTransformer $transformer,
    ) 
    {

    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'help' => 'Fill in the title',
                'attr' => [
                    'class' => 'form__title'
                ]
            ])
            ->add('text', TextareaType::class, [
                'required' => true 
            ])
            ->add('category', EntityType::class, [
                // looks for choices from this entity
                'class' => Category::class,
                'query_builder' => function ($repository) {
                    return $repository->createQueryBuilder('p')->orderBy('p.name', 'ASC');
                },
                'choice_label' => 'name',
                'required'   => false,
                'empty_data' => '',
                'placeholder' => '-- select category --'
            ])
            ->add('tags', TextType::class, [
                'label' => 'Тег',
                'required' => false
            ]);
        $builder->get('tags')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Blog::class, EntityType::class, [
            ]
        ]);
    }
}
