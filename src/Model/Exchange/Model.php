<?php namespace App\Model\Exchange;

use App\Model\Currency;

class Model
{
    /** @var string */
    protected $symbol;

    /** @var float */
    protected $bidAmount = null;

    /** @var float */
    protected $bidPrice = null;

    /** @var float */
    protected $count;

    /** @var float */
    protected $free = null;

    /** @var Currency */
    protected $currency;

    /**
     * @return string
     */
    public function getSymbol(): string
    {
        return $this->symbol;
    }

    /**
     * @param string $symbol
     * @return $this
     */
    public function setSymbol(string $symbol)
    {
        $this->symbol = $symbol;
        return $this;
    }

    /**
     * @return float
     */
    public function getBidAmount(): ?float
    {
        if ($this->bidAmount === null && $this->bidPrice !== null) {
            return $this->getBidPrice() * $this->count;
        }

        return $this->bidAmount;
    }

    /**
     * @param float $bidAmount
     * @return $this
     */
    public function setBidAmount(?float $bidAmount)
    {
        $this->bidAmount = $bidAmount;
        return $this;
    }

    /**
     * @return float
     */
    public function getBidPrice(): ?float
    {
        if ($this->bidPrice === null && $this->bidAmount !== null) {
            return $this->getBidAmount() / $this->count;
        }

        return $this->bidPrice;
    }

    /**
     * @param float $bidPrice
     * @return $this
     */
    public function setBidPrice(?float $bidPrice)
    {
        $this->bidPrice = $bidPrice;
        return $this;
    }

    /**
     * @return float
     */
    public function getCount(): float
    {
        return $this->count + $this->free;
    }

    /**
     * @param float $count
     * @return $this
     */
    public function setCount(float $count)
    {
        $this->count = $count;
        return $this;
    }

    /**
     * @return float
     */
    public function getFree(): ?float
    {
        return $this->free;
    }

    /**
     * @param float $free
     * @return $this
     */
    public function setFree(?float $free)
    {
        $this->free = $free;
        return $this;
    }

    /**
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * @param Currency $currency
     * @return $this
     */
    public function setCurrency(Currency $currency)
    {
        $this->currency = $currency;
        return $this;
    }

    public function getAmount(): float
    {
        return ($this->count + $this->free) * $this->currency->getPrice();
    }

    public function getEarn(): float
    {
        return $this->getAmount() - $this->getBidAmount();
    }

    public function getPercent(): float
    {
        $bidPrice = $this->getBidPrice();
        return $bidPrice > 0 ? $this->getEarn() * 100 / $this->getBidAmount() : 100;
    }

}