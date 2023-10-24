<?php

namespace App;

use App\IsoCodes;

class Application
{
    private Exchange $exchange;
    private IsoCodes $isoCodes;

    public function __construct()
    {
        $this->isoCodes = new IsoCodes();
    }

    public function run(): void
    {
        $this->exchange = $this->buildExchange();
        echo $this->exchange->exchange('USD', 100, 'EUR') . PHP_EOL;
    }

    public function buildExchange(): Exchange
    {
        $json = json_decode(
            file_get_contents("http://api.exchangeratesapi.io/v1/latest?access_key={$_ENV['API_KEY']}")
        );
        if (!$json->success) {
            die;
        }
        $currencies = [];
        foreach ($this->isoCodes->get() as $isoCode => $name) {
            if (property_exists($json->rates, $isoCode)) {
                $currencies[$isoCode] = new Currency($isoCode, $name, $json->rates->$isoCode);
            }
        }
        return new Exchange($json->timestamp, $currencies);
    }


}