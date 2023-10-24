<?php


namespace App;

class Currency
{
    private string $isoCode;
    private string $name;
    private float $rate;

    public function __construct(string $isoCode, string $name, float $rate)
    {
        $this->isoCode = $isoCode;
        $this->name = $name;
        $this->rate = $rate;
    }

    public function getIsoCode(): string
    {
        return $this->isoCode;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRate(): float
    {
        return $this->rate;
    }
}