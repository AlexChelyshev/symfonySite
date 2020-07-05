<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class, array(
                'label'=> 'выбор категорий',
                'class' => Category::class,
                'choice_label' => 'title'
            ))
            ->add('title', TextType::class, array(
                'label'=> 'заголовок поста',
                'attr' => [
                    'placeholder' => 'введите заголовок'
                ]
            ))
            ->add('content', TextareaType::class, array(
                'label'=> 'текст статьи',
                'attr' => [
                    'placeholder' => 'введите текст'
                ]
            ))
            ->add('image', FileType::class, array(
                'label'=> 'главное изображение',
                'required' => false,
                'mapped' => false
            ))
            ->add('save', SubmitType::class, array(
                'label'=> 'Сохранить',
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ))
            ->add('delete', SubmitType::class, array(
                'label'=> 'Удалить',
                'attr' => [
                    'class' => 'btn btn-danger'
                ]
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
