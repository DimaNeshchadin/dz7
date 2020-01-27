<?php

final class Currency
{
    const CURRENCY_USD = 'USD';
    const CURRENCY_EUR = 'EUR';

    private $currencies = [
        self::CURRENCY_EUR,
        self::CURRENCY_USD
    ];

    private $isoCode;

    public function __construct($isoCode)
    {
        $this->setIsoCode($isoCode);
    }

    public function getIsoCode()
    {
        return $this->isoCode;
    }

    private function setIsoCode($isoCode)
    {
        if (!in_array($isoCode, $this->currencies)) {
            throw new \InvalidArgumentException('Invalid currency');
        }
        $this->isoCode = $isoCode;
    }

    public function equals(Currency $currency)
    {
        if ($this->isoCode === $currency->getIsoCode()) {
            return true;
        }
        return false;
    }
}


final class Money
{
    private $amount;

    /** @var Currency */
    private $currency;

    public function __construct($amount, Currency $currency)
    {
        $this->setAmount($amount);
        $this->setCurrency($currency);
    }

    public function getAmount()
    {
        return $this->amount;
    }

    private function setAmount($amount): void
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Invalid amount');
        }

        $this->amount = $amount;
    }

    public function getCurrency():Currency
    {
        return $this->currency;
    }

    private function setCurrency($currency): void
    {
        $this->currency = $currency;
    }

    public function equals(Money $money)
    {
        if ($this->amount !== $money->getAmount() || !$this->currency->equals($money->getCurrency())) {
            return false;
        }
        return true;
    }

    public function add(Money $money)
    {
        if (!$this->currency->equals($money->getCurrency())) {
            throw new \InvalidArgumentException();
        }
        $this->amount += $money->getAmount();
    }
}

$usd = new Currency(Currency::CURRENCY_USD);
$eur = new Currency(Currency::CURRENCY_EUR);

//$usd->equals($eur);

$money1 = new Money (100, $usd);
$money2 = new Money (10, $usd);

//var_dump($money1);
//var_dump($money2);

//var_dump($money1->equals($money2));

$money1->add($money2);

//var_dump($money1);


echo $money1->getAmount() . ' ' . $money1->getCurrency()->getIsoCode();