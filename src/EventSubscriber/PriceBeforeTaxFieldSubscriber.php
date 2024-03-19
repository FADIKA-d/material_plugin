<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Event\PostSetDataEvent;


class PriceBeforeTaxFieldSubscriber implements EventSubscriberInterface
{
    public function onFormPostSetData(PostSetDataEvent $event): void
    {
        
        $material = $event->getData();
        $form = $event->getForm();


        if(isset($VAT) && ($form->get("VAT")->getData() !== $VAT)) {
            
            if(isset($priceBeforeTax)){
                
                $newPriceIncVAT = $priceBeforeTax * (1 + $VAT);
                $material["priceIncVAT"] = $newPriceIncVAT;
                $form->setData($material);
                //$form->get('priceIncVAT')->setData((string)$newPriceIncVAT);
                //$form->get('priceIncVAT')->setData('2');
            } else if(isset($priceIncVAT)){
                $newPriceBeforeTax = $priceIncVAT / (1 + $VAT);
                $form->get('priceBeforeTax')->setData((string)$newPriceBeforeTax);
            }
        }
    
            if(isset($priceBeforeTax) && ($form->get("priceBeforeTax")->getData() !== $priceBeforeTax)) {
                //dd($form->get("priceBeforeTax")->getData());
                if(isset($VAT)){
                    $newPriceIncVAT = $priceBeforeTax * (1 + $VAT);
                    $form->get('priceIncVAT')->setData((string)$newPriceIncVAT);
                    //$form->setData($priceIncVAT)
                } else if(isset($priceIncVAT)){
                    $VAT = $priceIncVAT - $priceBeforeTax;
                }
            }
    
            if(isset($priceIncVAT) && ($form->get("priceIncVAT")->getData() !== $priceIncVAT)) {
                //dd($form->get("priceBeforeTax")->getData());
                if(isset($VAT)){
                    $newPriceBeforeTax = $priceIncVAT / (1 + $VAT);
                    $form->get('priceBeforeTax')->setData((string)$newPriceBeforeTax);
                } else if(isset($priceBeforeTax)){
                    $VAT = $priceIncVAT - $priceBeforeTax;
                    //$form->setData($priceIncVAT)
                }
            
            }


//dd($material, $form);
        //if (isset($material['priceIncVAT'])){}
       /* if (1 === $material->getVAT()){
            dump("1");
        } elseif (2 === $material->getVAT()) {
            dump("2");
        }else {
            dump($form);
        }

        if (!$material || null === $material->getpriceBeforeTax()) {
            $form->get('priceIncVAT')->setData('2');
            dump(isset($produmaterialct['priceIncVAT']) );
        }
        if (null === $material->getpriceBeforeTax() && 1 === $material->getVAT()){

        }*/
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'form.post_set_data' => 'onFormPostSetData',
        ];
    }
   
}
