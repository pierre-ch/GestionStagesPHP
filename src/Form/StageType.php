<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Stage;
use App\Entity\Tuteur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('poste')
            ->add('description')
            ->add('type')
            ->add('actif')
            ->add('date_creation', null, [
                'widget' => 'single_text',
            ])
            ->add('date_expiration', null, [
                'widget' => 'single_text',
            ])
            ->add('date_modification', null, [
                'widget' => 'single_text',
            ])
            ->add('email')
            ->add('societe')
            ->add('ville')
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'id',
            ])
            ->add('tuteurs', EntityType::class, [
                'class' => Tuteur::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
