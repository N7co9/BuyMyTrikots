<?php

namespace App\Core;

use App\Model\BasketRepository;

class TotalCalculator
{
    private BasketRepository $basketRepository;

    public function __construct()
    {
        $this->basketRepository = new BasketRepository();
    }
    public function calculateTotal() : float
    {
        $total = 0.00;
        if(!empty($_SESSION['delivery']))
        {
            if($_SESSION['delivery'] === 'DHL')
            {
                $total = $this->basketRepository->getBasketTotal() + 4.95;
            } else if($_SESSION['delivery'] === 'DPD')
            {
                $total = $this->basketRepository->getBasketTotal() + 3.95;
            }else if($_SESSION['delivery'] === 'FedEX')
            {
                $total = $this->basketRepository->getBasketTotal() + 9.95;
            }

        }
        return $total;
    }
}