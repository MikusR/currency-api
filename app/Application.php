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
        //   $this->exchange = $this->buildExchange();
        $this->exchange = new Exchange(
            '1698151863',
            [
                'USD' => new Currency('USD', 'dol', 1.06),
                'EUR' => new Currency('EUR', 'eu', 1)
            ]
        );
        echo $this->exchange->exchange('USD', 100, 'EUR') . PHP_EOL;
        $this->ui();
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

    public function ui(): void
    {
        echo "Date of rates: " . $this->exchange->getTimestamp() . PHP_EOL;
        echo "1. to do currency conversion\n";
        echo "any other key to exit ";
        $choice = (int)readline();

        switch ($choice) {
            case 1:
                echo "enter amount and currency (ex: 100 USD) ";
                $userInput = explode(' ', readline());
                $amount = (int)$userInput[0];
                $currency = strtoupper($userInput[1]);
                if (array_key_exists($currency, $this->isoCodes->get()) === false) {
                    echo "no such currency\n";
                    break;
                }
                $currencyTo = strtoupper(readline("Currency to "));
                if (array_key_exists($currencyTo, $this->isoCodes->get()) === false) {
                    echo "no such currency\n";
                    break;
                }
                echo "You want to convert $amount {$this->isoCodes->get()[$currency]}\n";
                echo "Into {$this->isoCodes->get()[$currencyTo]}\n You get:\n";
                echo ($this->exchange->exchange($currency, 100 * $amount, $currencyTo)) / 100
                    . " {$this->isoCodes->get()[$currencyTo]}\n";

            default:
                die;
        }
    }

}