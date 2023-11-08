<?php

namespace App\Global\Business\DTO;

class OrderDTO
{
    public string $firstName = '';
    public string $lastName = '';
    public string $email = '';
    public string $address = '';
    public string $paymentMethod = '';
    public string $totalDue = '';
    public string $delivery = '';
    public string $zip = '';
    public string $city = '';
}