<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Form\Event\PreSetDataEvent;

final class AddPBTFieldListener
{
    #[AsEventListener(event: 'form.pre_set_data')]
    public function onFormPreSetData(PreSetDataEvent $event): void
    {
        $user = $event->getData();
        $form = $event->getForm();

        if (!$user) {
            return;
        }
        dump($event);
        dump($form);
        
    }
}
