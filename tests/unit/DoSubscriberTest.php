<?php

namespace App\Tests\unit;

use App\DTO\LowestPriceEnquiry;
use App\Event\AfterDtoCreatedEvent;
use App\EventSubscriber\DtoSubscriber;
use App\Service\ServiceException;
use App\Tests\ServiceTestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DoSubscriberTest extends ServiceTestCase
{
    /** @test */
    public function testEventSubscription(): void
    {
        $this->assertArrayHasKey(AfterDtoCreatedEvent::NAME, DtoSubscriber::getSubscribedEvents());
    }

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
        $this->expectExceptionMessage('ConstrainViolationList');

        // When
        $eventDispatcher->dispatch($event, $event::NAME);

        // Then
    }
}
