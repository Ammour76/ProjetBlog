<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name',TextType::class,[
            'label'=> "Nom de la catégorie",
                'required' => false,
                'attr' => [
                    "placeholder" => 'ajouter catégorie',
                    'class'=>'form-contol',
                ]
        ])
        // ->add('name',ChoiceType::class,[
        //     'choices'=>[
        //     "Par continent"=> 0,
        //     "Par Type de jeu"=> 1,  
        //     ],
        // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
