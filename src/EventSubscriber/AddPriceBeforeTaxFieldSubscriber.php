<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Event\SubmitEvent;

class AddPriceBeforeTaxFieldSubscriber implements EventSubscriberInterface
{
    public function onFormSubmit(SubmitEvent $event): void
    {
        //$form = $event->getData()->getVAT();
        //$type = gettype($event->getData()->getVAT());
        /*dd($event);
        dd($form->getValue());
        
        dd($form->getData()->getValue());
        dd($event->getData()->getPriceIncVAT());
        dd($event->getData()->getPriceBeforeTax());
        $material = $event->getData();
        $form = $event->getForm();
        dump("3");
        dump($material);*/
        $material = $event->getData();
        $form = $event->getForm();
        $data = $form->getData();
        

        $priceBeforeTax = $material->getPriceBeforeTax();
        $VAT = $material->getVAT();
        $priceIncVAT = $material->getPriceIncVAT();
      //dd($priceBeforeTax, $VAT, $priceIncVAT);
      //dd($VAT);
      //dd($priceIncVAT);
       //dd($material["priceBeforeTax"] , $form->get("priceBeforeTax")->getData());
      



        if(isset($VAT) && ($form->get("VAT")->getData() !== $VAT)) {
            
        if(isset($priceBeforeTax)){
            
            $newPriceIncVAT = $priceBeforeTax * (1 + $VAT);
            $material["priceIncVAT"] = $newPriceIncVAT;
            $form->setData($material);
            //$form->get('priceIncVAT')->setData((string)$newPriceIncVAT);
            $form->get('priceIncVAT')->setData('2');
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
    
      
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'form.submit' => ['onFormSubmit'],
        ];
    }
}
