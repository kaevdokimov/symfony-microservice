<?php

namespace App\Filter\Modifier;

use App\DTO\PromotionEnquiryInterface;
use App\Entity\Promotion;

class EvenItemsMultiplier implements PriceModifierInterface
{
    public function modify(int $price, int $quantity, Promotion $promotion, PromotionEnquiryInterface $enquiry): int
    {
        if ($quantity < 2)
            return $price * $quantity;

        $oddCount = $quantity % 2; // 0 or 1
        // Count how many even items
        $evenCount = $quantity - $oddCount;

        // ($adjustment * ($price * $evenCount)) + ($oddCount * $price)
        return ($promotion->getAdjustment() * ($price * $evenCount)) + ($oddCount * $price);
    }
}
