<?php

namespace App\EventSubscriber;

use App\Event\AfterDtoCreatedEvent;
use App\Service\ServiceException;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class DtoSubscriber implements EventSubscriberInterface
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
            throw new ServiceException(422, 'Validation failed');
        }
    }

    /*#[NoReturn] public function doSomethingElse():void
    {
        dd('doing something else');
    }*/
}
