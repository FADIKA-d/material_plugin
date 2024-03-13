<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Event\SubmitEvent;

class AddPriceBeforeTaxFieldSubscriber implements EventSubscriberInterface
{
    public function onFormSubmit(SubmitEvent $event): void
    {
        $material = $event->getData();
        $form = $event->getForm();

        //if (isset($material['priceIncVAT'])){}
        if (1 === $material->getVAT()){
            dump("1");
        } elseif (2 === $material->getVAT()) {
            dump("2");
        }else {
            dump("3");
        }

        if (!$material || null === $material->getpriceBeforeTax()) {
            $form->get('priceIncVAT')->setData('2');
            dump(isset($produmaterialct['priceIncVAT']) );
        }
        if (null === $material->getpriceBeforeTax() && 1 === $material->getVAT()){

        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'form.submit' => 'onFormSubmit',
        ];
    }
}
