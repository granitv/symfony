<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Project;
use App\Entity\Skill;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',\Symfony\Component\Form\Extension\Core\Type\TextType::class, [ 'attr' => ['class' => 'form-control']])
            ->add('description',\Symfony\Component\Form\Extension\Core\Type\TextType::class, [ 'attr' => ['class' => 'form-control']])
            ->add('image',FileType::class,['mapped'=>false, 'required' =>false, 'attr' => [ 'accept' => 'image/*' ,'class' => 'custom-file']])
            ->add('skill', EntityType::class,[ 'expanded' => true,
                'multiple' => true, 'class'=>Skill::class, 'choice_label'=>'name', 'attr' => ['class' => 'form-check']])
            ->add('save', SubmitType::class ,[ 'attr' => ['class' => 'btn-success btn my-2']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
