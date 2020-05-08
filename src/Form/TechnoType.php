<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Techno;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TechnoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [ 'attr' => ['class' => 'form-control']])
            ->add('category', EntityType::class, ['class' => Category::class, 'choice_label' => 'name', 'attr' => ['class' => 'form-control']])
            ->add('image',FileType::class,['mapped'=>false, 'required' =>false, 'attr' => [ 'accept' => 'image/*' ,'class' => 'custom-file']])
            ->add('save', SubmitType::class, [ 'attr' => ['class' => 'btn-success btn my-2']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Techno::class,
        ]);
    }

}