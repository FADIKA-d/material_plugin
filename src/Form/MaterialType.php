<?php

namespace App\Form;

use App\EventSubscriber\AddPriceBeforeTaxFieldSubscriber;
use App\EventSubscriber\PriceBeforeTaxFieldSubscriber;
use App\Entity\Material;
use App\Entity\VAT;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class MaterialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('quantity')
            ->add('createdAt')
            ->add('priceBeforeTax')
            ->add('priceIncVAT')
            ->add('VAT', EntityType::class, [
                'class' => VAT::class,
                'choice_label' => 'id',
                'placeholder' => 'choisir',
            ])
        ;
       
       
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $data = $event->getData();
                $form = $event->getForm();

                
                if (!$data) {
                    return;
                }
        
                // Manipuler les données du formulaire en fonction de $data
                // Par exemple, ajouter ou supprimer des champs en fonction des données du formulaire
            }
        );
        $builder->addEventSubscriber(new AddPriceBeforeTaxFieldSubscriber());
        $builder->addEventSubscriber(new PriceBeforeTaxFieldSubscriber());
       

        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Material::class,
        ]);
    }
    public function onPreSetData(PreSetDataEvent $event): void
    {
        $product = $event->getData();
        $form = $event->getForm();
        dump($product);
    }
}
