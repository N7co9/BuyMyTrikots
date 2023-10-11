<?php

namespace Model;

use App\Model\BasketRepository;
use PHPUnit\Framework\TestCase;

class BasketRepositoryTest extends TestCase
{
    private BasketRepository $basketRepository;
public function setUp(): void
{
    $this->basketRepository = new BasketRepository();
    parent::setUp(); // TODO: Change the autogenerated stub
}

    public function testGetBasketInfo() : void
    {
    $_SESSION['mail'] = 'validation@validation.com';
    $basket = $this->basketRepository->getBasketInfo();

    self::assertSame('', $basket);
    }

    public function testGetItemQuantity() : void
    {
        $_SESSION['mail'] = 'validation@validation.com';
        $quantity = $this->basketRepository->getItemQuantity(165);

        self::assertSame('', $quantity);
    }
}