<?php

namespace App\EventSubscriber;

use App\Event\AfterDtoCreatedEvent;
use App\Service\ServiceException;
use App\Service\ServiceExceptionData;
use App\Service\ValidationExceptionData;
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
            $validationExceptionData = new ValidationExceptionData(422, 'ConstrainViolationList', $errors);
            throw new ServiceException($validationExceptionData);
        }
    }

    /*#[NoReturn] public function doSomethingElse():void
    {
        dd('doing something else');
    }*/
}
