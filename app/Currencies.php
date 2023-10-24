<?php

namespace App;

class Currencies
{
    private array $currencies;


    public function __construct(array $currencies)
    {
        $this->currencies = $currencies;
    }

    public function get(string $isoCode): Currency
    {
        return $this->currencies[$isoCode];
    }

    public function list(): array
    {
        return $this->currencies;
    }
}