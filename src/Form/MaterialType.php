<?php

namespace App\Form;

use App\EventSubscriber\MaterialEventSubscriber;
use App\EventSubscriber\PriceBeforeTaxFieldSubscriber;
use App\Entity\Material;
use App\Entity\VAT;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaterialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label'=> 'Nom',
            ])
            ->add('quantity', IntegerType::class, [
                'label'=> 'Quantité',
                'attr' => [
                    'min'=> '0'
                ],
                'required' => true
            ])
            ->add('priceBeforeTax', MoneyType::class, [
                'label'=> 'Prix HT',
                'scale' => 2,
                'attr' => [
                    'min'=> '0'
                ],
                'required' => true
            ])
            ->add('priceIncVAT', MoneyType::class, [
                'label'=> 'Prix TTC',
                'scale' => 2,
                'attr' => [
                    'min'=> '0'
                ],
                'required' => true
            ])
            ->add('VAT', EntityType::class, [
                'class' => VAT::class,
                'choice_value' => 'value',
                'placeholder' => 'Sélectionner une valeur',
                'label' => 'Taux de TVA',
            ])
        ;

        //$builder->addEventSubscriber(new AddPriceBeforeTaxFieldSubscriber());
        $builder->addEventSubscriber(new PriceBeforeTaxFieldSubscriber());
        $builder->addEventSubscriber(new MaterialEventSubscriber());
       $builder->getForm();

        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Material::class,
        ]);
    }

}
