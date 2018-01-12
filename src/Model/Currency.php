<?php namespace App\Model;

class Currency
{
    /** @var string */
    protected $name;

    /** @var  string */
    protected $symbol;

    /** @var float */
    protected $price;

    /** @var float */
    protected $priceUSD;

    /** @var float */
    protected $priceETH;

    /** @var float */
    protected $priceBTC;


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return $this
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return float
     */
    public function getPriceUSD(): float
    {
        return $this->priceUSD;
    }

    /**
     * @param float $priceUSD
     * @return $this
     */
    public function setPriceUSD(float $priceUSD)
    {
        $this->priceUSD = $priceUSD;
        return $this;
    }

    /**
     * @return float
     */
    public function getPriceETH(): float
    {
        return $this->priceETH;
    }

    /**
     * @param float $priceETH
     * @return $this
     */
    public function setPriceETH(float $priceETH)
    {
        $this->priceETH = $priceETH;
        return $this;
    }

    /**
     * @return float
     */
    public function getPriceBTC(): float
    {
        return $this->priceBTC;
    }

    /**
     * @param float $priceBTC
     * @return $this
     */
    public function setPriceBTC(float $priceBTC)
    {
        $this->priceBTC = $priceBTC;
        return $this;
    }

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


}