<?php namespace App\Service;

class Alert
{
    protected $baseurl = 'https://api.binance.com/api/v1/klines';

    protected $limit = 5;

    protected $interval = "1m";

    protected $symbol = "LTCBTC";

//    $pro



    public function parse()
    {
        //device token
        $deviceToken = "a58c9e7406c4b591eda8f192027d00ef82cdba361821f693e7b8ac9cb3afbc61";

//Message will send to ios device
        $message = 'this is custom message';

//certificate file
//        $apnsCert = __DIR__ . '/../../key.pem';

        $items = json_decode(file_get_contents($this->prepareUrl()));
        $data = [];
        foreach ($items as $item) {
            $row = (object)[
                'date' => new \DateTime($item[0]),
                'open' => $item[1],
                'close' => $item[4],
                'differenece'
            ];
        }

        exit;
    }

    protected function prepareUrl()
    {
        return $this->baseurl . "?" . http_build_query([
                'limit' => $this->limit,
                'symbol' => $this->symbol,
                'interval' => $this->interval,
            ]);
    }
}