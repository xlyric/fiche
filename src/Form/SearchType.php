<?php

namespace App\Form;

use App\Classe\Search;
use App\Entity\Categorie;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('string', TextType::class, [
                'label' =>'Rechercher',
                'required' =>false, 
                'attr' => [
                    'placeholder' => 'votre recherche',
                    'class' => 'form-control-sm' ,
                    'white-space' =>'pre'
                ],
                
                ])
            ->add('categories',EntityType::class,[
                'label' => false,
                'required' => false,
                'class' => Categorie::class,
                'multiple' => true,
                'expanded' => true,
                

            ])
            ->add('submit', SubmitType::class, [
                'label' => 'filtrer',
                'attr' => [ 'class' => 'btn-block btn-info ' ]
            ]);

    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
    
}
