<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\Property;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',null, ['label'=>'Titre'])
            ->add('description')
            ->add('surface')
            ->add('rooms',null, ['label'=>'Piéces'])
            ->add('bedrooms',null, ['label'=>'Chambre'])
            ->add('floor',null, ['label'=>'Etage'])
            ->add('price', null,['label'=>'Prix'])
            ->add('heat',ChoiceType::class,[
                'choices'=> $this->getChoices()
            ])
            ->add('options',EntityType::class,[
                 'class' => Option::class,
                 'choice_label'=>'name',
                 'multiple'=> true
            ])
            ->add('pictureFiles',FileType::class,[
                'required'=> false,
                'multiple' => true
            ])
            ->add('city',null,['label'=>'Ville'])
            ->add('address',null, ['label'=>'adresse'])
            ->add('postal_code',null,['label'=>'Code postale'])
            ->add('sold',null,['label'=>'Vendu'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class
        ]);
    }

    private function getChoices()
    {
        $choices = Property::HEAT;
        $output=[];

        foreach ( $choices as $k => $v) {
            $output[$v]=$k;
        }
        return $output;
    }

}
