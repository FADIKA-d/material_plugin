<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Form\Event\PostSetDataEvent;

final class AddPriceBeforeTaxFieldListener
{
    #[AsEventListener(event: 'form.post_set_data')]
    public function onFormPostSetData(PostSetDataEvent $event): void
    {
        $product = $event->getData();
        $form = $event->getForm();

        if (!$product) {
            var_dump($product);
        }

    }
}


