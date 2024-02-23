<?php

namespace App\EventSubscriber;

use App\Event\AfterDtoCreatedEvent;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DtoSubscriber implements EventSubscriberInterface
{

    public function __construct(private ValidatorInterface $validator)
    {

    }

    public static function getSubscribedEvents(): array
    {
        return [
            AfterDtoCreatedEvent::NAME => [
                ['validateDto', 100],
                //['doSomethingElse', 1]
            ]
        ];
    }

    public function validateDto(AfterDtoCreatedEvent $event): void
    {
        $dto = $event->getDto();

        $errors = $this->validator->validate($dto);

        if(count($errors) > 0) {
            throw new ValidationFailedException('Validation failed', $errors);
        }
    }

    /*#[NoReturn] public function doSomethingElse():void
    {
        dd('doing something else');
    }*/
}
