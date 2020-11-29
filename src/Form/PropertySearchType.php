<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\PropertySearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',null,['label' =>false,
                              'attr' => ['requied' => false, 
                                         'placeholder' => 'Entrer le nom d\'un article'] ] ) 
            ->add('categorie',EntityType::class,[
        'class'=>Categorie::class,
         'choice_label'=>'Nom_cat',
        'attr'=>[
            'class'=>'form-control',
            'class'=>'col-lg-5'
        ],
        'label'   => false,
        //dropdow listto display nom of category
    ])
    ->add('prixmin',null,['label' =>false,
                              'attr' => ['requied' =>false, 
                                         'placeholder' => 'Entrer le prix min'] ])
    ->add('prixmax',null,['label' =>false,
                                         'attr' => ['requied' =>false, 
                                                    'placeholder' => 'Entrer le prix max'] ] ) ;                                      


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
        ]);
    }
}
