<?php

namespace App\Tests\unit;

use App\DTO\LowestPriceEnquiry;
use App\DTO\PromotionEnquiryInterface;
use App\Entity\Promotion;
use App\Filter\LowestPriceFilter;
use App\Tests\ServiceTestCase;

class LowestPriceFilterTest extends ServiceTestCase
{
    /** @test */
    public function lowest_price_promotions_filtering_is_applied_correctly(): void
    {
        // Given
        $enquiry = new LowestPriceEnquiry();
        $promotions = $this->promotionsDataProvider();
        $lowestPriceFilter = $this->container->get(LowestPriceFilter::class);

        // When
        /** @var LowestPriceEnquiry $filteredEnquiry */
        $filteredEnquiry = $lowestPriceFilter->apply($enquiry, ...$promotions);

        // Then
        $this->assertSame(100, $filteredEnquiry->getPrice());
        $this->assertSame(50, $filteredEnquiry->getDiscountedPrice());
        $this->assertSame('Black Friday half price sale', $filteredEnquiry->getPromotionName());
    }

    public function promotionsDataProvider():array
    {
        $promotionsOne = new Promotion();
        $promotionsOne->setName('Black Friday half price sale');
        $promotionsOne->setAdjustment(0.5);
        $promotionsOne->setCriteria(['from' => '2022-11-25', 'to' => '2022-11-28']);
        $promotionsOne->setType('date_range_multiplier');

        $promotionsTwo = new Promotion();
        $promotionsTwo->setName('Voucher OU812');
        $promotionsTwo->setAdjustment(100);
        $promotionsTwo->setCriteria(['code' => 'OU812']);
        $promotionsTwo->setType('fixed_price_voucher');

        $promotionsThree = new Promotion();
        $promotionsThree->setName('Buy one get one free');
        $promotionsThree->setAdjustment(0.5);
        $promotionsThree->setCriteria(['minimum_quantity' => 2]);
        $promotionsThree->setType('date_range_multiplier');

        return [$promotionsOne, $promotionsTwo, $promotionsThree];
    }

}
