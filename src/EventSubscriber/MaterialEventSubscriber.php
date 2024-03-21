<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Event\PreSubmitEvent;

class MaterialEventSubscriber implements EventSubscriberInterface
{
    public function onFormPreSubmit(PreSubmitEvent $event): void
    {
        $material = $event->getData();
        $form = $event->getForm();

        $priceBeforeTax = implode('.', explode(',', $material["priceBeforeTax"]));
        $VAT = $material["VAT"];
        $priceIncVAT = implode('.', explode(',', $material["priceIncVAT"]));


       if(isset($VAT) && ($form->get("VAT")->getData() !== $VAT)) {
            
        if(isset($priceBeforeTax)){
            
            $newPriceIncVAT = $priceBeforeTax * (1 + $VAT);
            $form->get('priceIncVAT')->setData((string)$newPriceIncVAT);

        } else if(isset($priceIncVAT)){
            $newPriceBeforeTax = $priceIncVAT / (1 + $VAT);
            $form->get('priceBeforeTax')->setData((string)$newPriceBeforeTax);
        }
    }

        if(isset($priceBeforeTax) && ($form->get("priceBeforeTax")->getData() !== $priceBeforeTax)) {
         
            if(isset($VAT)){
                $newPriceIncVAT = $priceBeforeTax * (1 + $VAT);
                $form->get('priceIncVAT')->setData((string)$newPriceIncVAT);
       
            } else if(isset($priceIncVAT)){
                //$VAT = (($priceIncVAT - $priceBeforeTax)$priceBeforeTax)*100;
            }
        }

        if(isset($priceIncVAT) && ($form->get("priceIncVAT")->getData() !== $priceIncVAT)) {
            //dd($form->get("priceBeforeTax")->getData());
            if(isset($VAT)){
                $newPriceBeforeTax = $priceIncVAT / (1 + $VAT);
                $form->get('priceBeforeTax')->setData((string)$newPriceBeforeTax);
            } else if(isset($priceBeforeTax)){
                //$VAT = (($priceIncVAT - $priceBeforeTax)$priceBeforeTax)*100;
            }
        
        }
    

    }

    public static function getSubscribedEvents(): array
    {
        return [
            'form.pre_submit' => 'onFormPreSubmit',
        ];
    }
}
