<?php

namespace App\Tests\unit;

use App\DTO\LowestPriceEnquiry;
use App\Event\AfterDtoCreatedEvent;
use App\Service\ServiceException;
use App\Tests\ServiceTestCase;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DoSubscriberTest extends ServiceTestCase
{
    /** @test */
    public function tesValidateDto(): void
    {
        // Given
        $dto = new LowestPriceEnquiry();
        $dto->setQuantity(-5);
        $event = new AfterDtoCreatedEvent($dto);

        /** @var  EventDispatcherInterface $eventDispatcher */
        $eventDispatcher = $this->container->get('event_dispatcher');

        // Except
        $this->expectException(ServiceException::class);
        $this->expectExceptionMessage('Validation failed');

        // When
        $eventDispatcher->dispatch($event, $event::NAME);

        // Then
    }
}
