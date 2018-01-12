<?php namespace App\Service;

use App\Model\Currency as Model;

class Currency
{
    /**
     * @var array
     */
    protected $config;

    /**
     * Exchange constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return Collection|Model[]
     */
    public function getCurrencies()
    {
        $items = json_decode(file_get_contents($this->prepareUrl()));
        $currencies = [];
        foreach ($items as $item) {
            $currency = new Model();
            $currency
                ->setName($item->name)
                ->setSymbol($item->symbol)
                ->setPrice($item->price_pln)
                ->setPriceBTC($item->price_btc)
                ->setPriceUSD($item->price_usd)
            ;

            $currencies[] = $currency;
        }
        return $currencies;
    }

    protected function prepareUrl()
    {
        return $this->config['baseurl'] . '?convert=PLN&limit=200';
    }
}
